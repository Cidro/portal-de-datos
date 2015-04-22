<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * Dataset
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Dataset extends EntityRepository{
    public function getDatasetEntidadServicio($options = null){

        $options['order_by'] = isset($options['order_by'])?$options['order_by']:'d.id';
        $options['order_dir'] = isset($options['order_dir'])?$options['order_dir']:'DESC';
        $options['offset'] = isset($options['offset'])?$options['offset']:0;
        $options['limit'] = isset($options['limit'])?$options['limit']:10;
        $options['total'] = isset($options['total'])?$options['total']:false;

        $ci = &get_instance();

        $select = $options['total'] ? 'COUNT(d.id)' : 'd';

        $qb = $this->_em->createQueryBuilder();

        $qb->select($select)
             ->from('Entities\Dataset', 'd')
             ->leftJoin('d.servicio', 's');

        $qb->where('d.maestro = 1');

        if(!$ci->user->getMinisterial() && !$ci->user->getInterministerial()){
            $options['codigo_servicio'] = $ci->user->getServicio()->getCodigo();
        }elseif(!$ci->user->getInterministerial()){
            $options['codigo_entidad'] = $ci->user->getServicio()->getEntidad()->getCodigo();
        }

        if(isset($options['codigo_servicio']) && $options['codigo_servicio']){
            $qb->andWhere('s.codigo = :codigoservicio');
            $qb->setParameter('codigoservicio', $options['codigo_servicio']);
        }
        
        if(isset($options['codigo_entidad']) && $options['codigo_entidad']){
             $qb->leftJoin('s.entidad' , 'e');
            $qb->andWhere('e.codigo = :codigoentidad');
            $qb->setParameter('codigoentidad', $options['codigo_entidad']);
        }

        if(isset($options['titulo_dataset']) && $options['titulo_dataset']){
            $qb->andWhere('d.titulo like :titulodataset');
            $qb->setParameter('titulodataset', '%'.$options['titulo_dataset'].'%');
        }

        if(isset($options['junar']) && $options['junar']){
            $qb->andWhere('d.integracion_junar IS NOT NULL');
        }

        if(isset($options['con_recurso']) && $options['con_recurso']){
            $qb->leftJoin('d.recursos', 'r')
                ->andWhere('r.id IS NOT NULL');
        }

        if(!$options['total']){
            return $qb->orderBy($options['order_by'], $options['order_dir'])
                                ->setFirstResult($options['offset'])
                                ->setMaxResults($options['limit'])
                                ->getQuery()
                                ->getResult();
        }else{
            return $qb->getQuery()->getSingleScalarResult();
        }
    }

    /*Obtiene un listado de datasets publicados segun un ordenamiento y rangos entregados*/
    public function findWithOrdering($options = null, $ordering = array('updated_at' => 'DESC'), $limit = 4, $offset = 0){
        $qb = $this->_em->createQueryBuilder();

        $qb->from('Entities\Dataset', 'd');

        if(isset($options['total'])){

            $qb->select('COUNT(d.id)');

        }else{

            $qb->select('d');

            foreach ($ordering as $field => $dir) {
                if($field == 'ndescargas'){

                    $qb->select('d, SUM(des.count) AS total_descargas')
                        ->leftJoin('d.recursos', 'r')
                        ->leftJoin('r.descargas', 'des')
                        ->groupBy('d.id')
                        ->addOrderBy('total_descargas', 'DESC')
                        ->add('where', new \Doctrine\ORM\Query\Expr\Comparison('des.fecha', '>', "DATE_SUB(CURRENT_TIMESTAMP(), 1, 'MONTH')"));

                }elseif($field == 'rating'){
                    $qb->leftJoin('d.datasetMaestro', 'datasetMaestro')
                         ->addOrderBy('datasetMaestro.rating', $dir);
                }elseif($field == 'hits'){
                    $qb->leftJoin('d.datasetMaestro', 'datasetMaestro')
                         ->addOrderBy('datasetMaestro.hits', $dir);
                }elseif($field == 'updated_at'){
                    //Fecha de primera publicacion
                    $qb->leftJoin('d.datasetMaestro', 'datasetMaestro')
                         ->leftJoin('datasetMaestro.primeraVersionPublicada', 'primeraVersionPublicada')
                         ->addOrderBy('primeraVersionPublicada.created_at', $dir);
                }else{
                    $qb->addOrderBy('d.'.$field, $dir);
                }
            }

        }
        
        if(isset($options['meaestros']) && $options['meaestros']){
            $qb->andWhere('d.maestro = 1');
        }else{
            $qb->andWhere('d.maestro = 0 AND d.publicado = 1');
        }

        if($options){
            if(isset($options['entidad_codigo'])){
                $qb->leftJoin('d.servicio', 's')
                    ->andWhere('s.publicado = 1')
                    ->andWhere('s.entidad_codigo = :entidad_codigo')
                    ->setParameter('entidad_codigo', $options['entidad_codigo']);
            }
            if(isset($options['servicio_codigo'])){
                $qb->andWhere('d.servicio_codigo = :servicio_codigo')
                     ->setParameter('servicio_codigo', $options['servicio_codigo']);
            }
            if(isset($options['idtag'])){
                $qb->leftJoin('d.tags', 't')
                     ->andWhere('t.id = :idtag')
                     ->setParameter('idtag', $options['idtag']);
            }
            if(isset($options['idcategoria'])){
                $qb->leftJoin('d.categorias', 'c')
                     ->andWhere('c.id = :idcategoria')
                     ->setParameter('idcategoria', $options['idcategoria']);
            }
            if(isset($options['idusuario'])){
                $qb->leftJoin('d.logMaestro', 'l')
                    ->leftJoin('l.usuario', 'u')
                    ->andWhere('u.id = :idusuario')
                    ->setParameter('idusuario', $options['idusuario']);
            }
            if(isset($options['id_maestros'])){
                $qb->andWhere('d.maestro_id IN (:id_maestros)')
                    ->setParameter('id_maestros', $options['id_maestros']);
            }
        }

        if(isset($options['total'])){

            return $qb->getQuery()->getSingleScalarResult();

        }else{

            $query = $qb->setFirstResult($offset)
                                    ->setMaxResults($limit)
                                    ->getQuery();

            return $query->getResult();

        }

    }

    public function getMasVistos($limit = 10, $fecha_desde = null, $reporte = false)
    {
        $qb = $this->_em->createQueryBuilder();

        if($reporte){
            $qb->select('d.maestro_id, sum(v.count) as vistas')
                ->from('Entities\Dataset', 'd', 'd.maestro_id');
        }else{
            $qb->select('d, sum(v.count) as vistas')
                ->from('Entities\Dataset', 'd')
                ->setMaxResults($limit);
        }

        $qb->leftJoin('d.datasetMaestro', 'dm')
            ->leftJoin('dm.vistas', 'v')
            ->groupBy('d.id')
            ->orderBy('vistas', 'desc')
            ->where('d.maestro = 0 AND d.publicado = 1');

        if($fecha_desde)
            $qb->andWhere('v.fecha >= :fecha_desde')
                ->setParameter(':fecha_desde', $fecha_desde);

        return $reporte?$qb->getQuery()->getArrayResult():$qb->getQuery()->getResult();
    }

    public function getMasDescargados($limit = 10, $fecha_desde = null, $reporte = false)
    {
        $qb = $this->_em->createQueryBuilder();

        if($reporte){
            $qb->select('d.maestro_id, sum(ds.count) as descargas')
                ->from('Entities\Dataset', 'd', 'd.maestro_id');
        }else{
            $qb->from('Entities\Dataset', 'd')
                ->select('d, sum(ds.count) as descargas')
                ->setMaxResults($limit);
        }

        $qb->leftJoin('d.recursos', 'r')
            ->leftJoin('r.descargas', 'ds')
            ->groupBy('d.id')
            ->orderBy('descargas', 'desc')
            ->where('d.maestro = 0 AND d.publicado = 1');

        if($fecha_desde){
            $qb->andWhere('ds.fecha >= :fecha_desde')
                ->setParameter(':fecha_desde', $fecha_desde);
        }

        return $reporte?$qb->getQuery()->getArrayResult():$qb->getQuery()->getResult();
    }

    /*Obtiene el dataset publicado del dataset maestro entragado*/
    public function getDatasetPublicado($idMaestro){
        $qb = $this->_em->createQueryBuilder();

        $query = $qb->select('d')
             ->from('Entities\Dataset', 'd')
             ->where('d.maestro = 0 AND d.publicado = 1 AND d.maestro_id = :maestroid')
             ->setParameter('maestroid', $idMaestro)
             ->getQuery();

        return $query->getOneOrNullResult();
    }

    // Obtiene el total de datasets que se han publicado
    public function getTotalDatasetsPublicados()
    {
        $qb = $this->_em->createQueryBuilder();

        $query = $qb->select('count(d.id) as ndatasets')
             ->from('Entities\Dataset', 'd')
             ->where('d.maestro = 0 AND d.publicado = 1')
             ->getQuery();

        return $query->getSingleScalarResult();
    }

    /*Obtiene el total de descargas del dataset entregado*/
    public function getTotalDescargas($dataset){
        $qb = $this->_em->createQueryBuilder();

        $qb->select('SUM(descarga.count) as suma')
                                ->from('Entities\Descarga', 'descarga')
                                ->leftJoin('descarga.recurso', 'recurso');

        if($dataset->getMaestro())
            $qb->leftJoin('recurso.dataset', 'datasetVersion')
                 ->leftJoin('datasetVersion.datasetMaestro', 'dataset');
        else
            $qb->leftJoin('recurso.dataset', 'dataset');

        $query = $qb->where('dataset.id = :datasetid')
                                ->setParameter('datasetid', $dataset->getId())
                                ->getQuery();

        return $query->getSingleScalarResult();
    }

    /*obtiene el promedio de las evaluaciones del dataset entregado*/
    public function getPromedioEvaluaciones($dataset){

        $qb = $this->_em->createQueryBuilder();

        $qb->select('AVG(evaluacion.rating) as promedio')
             ->from('Entities\Evaluacion', 'evaluacion');
        if($dataset->getMaestro())
            $qb->leftJoin('evaluacion.dataset', 'datasetVersion')
                 ->leftJoin('datasetVersion.datasetMaestro', 'dataset');
        else
            $qb->leftJoin('evaluacion.dataset', 'dataset');
        
        $query = $qb->where('dataset.id = :datasetid')
                                ->setParameter('datasetid', $dataset->getId())
                                ->getQuery();

        return $query->getSingleScalarResult();
    }

    /*Obtiene la cantidad de datasets del usuario con reportes pendientes*/
    public function getDatasetsConReportesPorEstadosUsuario(\Entities\User $user, $estados = array(2,3,5))
    {
        $codigo_servicio = null;
        $codigo_entidad = null;

        if(!$user->getMinisterial() && !$user->getInterministerial()){
            $codigo_servicio = $user->getServicio()->getCodigo();
        }elseif(!$user->getInterministerial()){
            $codigo_entidad = $user->getServicio()->getEntidad()->getCodigo();
        }

        $qb = $this->_em->createQueryBuilder();

        $qb->select('COUNT(DISTINCT d.id) AS datasets')
            ->from('Entities\Dataset', 'd')
            ->leftJoin('d.reportes', 'r')
            ->leftJoin('d.servicio', 's')
            ->andWhere('r.estado IN (:ids)')
            ->setParameter('ids', $estados)
            ->andWhere('d.publicado = 1')
            ->andWhere('d.maestro = 1');

        if($codigo_servicio){
            $qb->andWhere('s.codigo = :codigoservicio');
            $qb->setParameter('codigoservicio', $codigo_servicio);
        }
        
        if($codigo_entidad){
            $qb->leftJoin('s.entidad' , 'e');
            $qb->andWhere('e.codigo = :codigoentidad');
            $qb->setParameter('codigoentidad', $codigo_entidad);
        }

        return intval($qb->getQuery()->getSingleScalarResult());
    }

    // Obtiene un arreglo con los nombres de los campos publicos del dataset
    public function getCampoDataset()
    {
        return array(
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'servicio_codigo' => 'Institución',
            'licencia_id' => 'Licencia',
            'tags' => 'Etiquetas',
            'categorias' => 'Categorías',
            'frecuencia' => 'Frecuencia actualización',
            'sectores' => 'Cobertura Geográfica',
            'granularidad' => 'Granularidad',
            'recursos' => 'Recursos',
            'documentos' => 'Documentos'
        );
    }

    //Obtiene los datasets nuevos basandose en la fecha de publicación del primer dataset publicado
    public function findDatasetsNuevos($limit = 10)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('d')
            ->from('Entities\Dataset', 'd')
            ->leftJoin('d.datasetMaestro', 'dm')
            ->leftJoin('dm.primeraVersionPublicada', 'dp')
            ->andWhere('d.maestro = 0')
            ->andWhere('d.publicado = 1')
            ->orderBy('dp.publicado_at', 'DESC')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function search($q, $options, $ordering, $limit = 10, $offset = 0){
        $ci = &get_instance();
        $ci->load->helper("sphinx");

        /* LIMITA RESULTADOS */
        $search_result = search($q, null, 10000, 0, $ordering);

        if(!$search_result || intval($search_result['total']) === 0)
            return false;

        //Se arreglan los ids obtenidos para utilizarlos en el query
        foreach ($search_result['matches'] as $id => $data) {
            $datasetIds[] = $id;
        }

        $datasetIds = implode(', ', $datasetIds);

        $select = $options['total'] ? 'COUNT(d.id)' : 'd, FIELD(d.id, '.$datasetIds.') AS HIDDEN field';

        //Se agrega la funcion field a doctrine
        $dc = $this->_em->getConfiguration();
        $dc->addCustomStringFunction('FIELD', 'DoctrineExtensions\Query\Mysql\Field');

        $qb = $this->_em->createQueryBuilder();

        $qb->select($select)
            ->from('Entities\Dataset', 'd')
            ->leftJoin('d.servicio', 's');

        $qb->where('d.maestro = 0')
            ->andWhere('d.publicado = 1')
            ->andWhere('d.id IN ('.$datasetIds.')');

        foreach ($ordering as $field => $dir) {
            if($field == 'ndescargas'){
                $qb->leftJoin('d.datasetMaestro', 'datasetMaestro')
                     ->addOrderBy('datasetMaestro.ndescargas', $dir);
            }elseif($field == 'rating'){
                $qb->leftJoin('d.datasetMaestro', 'datasetMaestro')
                     ->addOrderBy('datasetMaestro.rating', $dir);
            }elseif($field == 'hits'){
                $qb->leftJoin('d.datasetMaestro', 'datasetMaestro')
                     ->addOrderBy('datasetMaestro.hits', $dir);
            }elseif($field == 'titulo'){
                $qb->orderBy('d.titulo', $dir);
            }else{
                $qb->orderBy('field');
            }
        }
        $results = $qb->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        return array('datasets' => $results, 'total' => $search_result['total']);
    }

    public function getDescargasDatasetsPeriodo($options)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('d.id, SUM(des.count) AS total_descargas')
            ->from('Entities\Dataset', 'd', 'd.id')
            ->leftJoin('d.datasetVersion', 'dv')
            ->leftJoin('dv.recursos', 'r')
            ->leftJoin('r.descargas', 'des')
            ->andWhere('d.maestro = 1')
            ->groupBy('d.id');

        if(isset($options['id_maestros'])){
            $qb->andWhere('d.id IN (:id_maestros)')
                ->setParameter('id_maestros', $options['id_maestros']);
        }
        if(isset($options['fecha_mes'])){
            $qb->andWhere('SUBSTRING(des.fecha, 6, 2) = :fecha_mes')
                ->setParameter('fecha_mes', $options['fecha_mes']);
        }
        if(isset($options['fecha_ano'])){
            $qb->andWhere('SUBSTRING(des.fecha, 1, 4) = :fecha_ano')
                ->setParameter('fecha_ano', $options['fecha_ano']);
        }

        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    public function getVistasDatasetsPeriodo($options)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('d.id, SUM(v.count) AS total_vistas')
            ->from('Entities\Dataset', 'd', 'd.id')
            ->leftJoin('d.vistas', 'v')
            ->andWhere('d.maestro = 1')
            ->andWhere('d.publicado = 1')
            ->groupBy('d.id');

        if(isset($options['id_maestros'])){
            $qb->andWhere('d.id IN (:id_maestros)')
                ->setParameter('id_maestros', $options['id_maestros']);
        }
        if(isset($options['fecha_mes'])){
            $qb->andWhere('SUBSTRING(v.fecha, 6, 2) = :fecha_mes')
                ->setParameter('fecha_mes', $options['fecha_mes']);
        }
        if(isset($options['fecha_ano'])){
            $qb->andWhere('SUBSTRING(v.fecha, 1, 4) = :fecha_ano')
                ->setParameter('fecha_ano', $options['fecha_ano']);
        }

        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    public function grabaDataset($dataset, $atributos = array(), $esNuevo = true){
        if(!empty($atributos))
            $dataset = $this->asignaAtributosDataset($dataset, $atributos);

        $this->_em->persist($dataset);
        $this->_em->flush();

        if(isset($atributos['recurso']) && !empty($atributos['recurso'])){
            $dataset = $this->actualizaRecursosDataset($dataset, $atributos['recurso']);
        }

        $this->_em->persist($dataset);
        $this->_em->flush();

        //Se crea la version inicial del dataset
        $nuevaVersion = $dataset->generaVersion();

        if($esNuevo){
            $nuevaVersion->setPublicado($dataset->getPublicado());
        }else{
            $nuevaVersion->setPublicado(!$dataset->getPublicado());
            $nuevaVersion->togglePublicado();
        }

        $this->_em->persist($nuevaVersion);
        $this->_em->flush();

        return $dataset;
    }

    public function creaDataset($atributos){
        $dataset = new \Entities\Dataset;

        return $this->grabaDataset($dataset, $atributos, true);
    }

    function actualizaDataset($dataset, $atributos){
        return $this->grabaDataset($dataset, $atributos, false);
    }

    function asignaAtributosDataset($dataset, $atributos){
        $CI = &get_instance();
        $CI->load->helper('array');
        $tags = array();

        $servicio = $this->_em->getRepository('Entities\Servicio')->findOneByCodigo(element('servicio_codigo', $atributos));
        $categorias = $this->_em->getRepository('Entities\Categoria')->getByIds(element('categorias_id', $atributos, ''));
        $licencia = $this->_em->getRepository('Entities\Licencia')->findOneBy(array('id' => element('licencia_id', $atributos, '')));
        $nombresTags = element('tags', $atributos);

        $dataset->setTitulo(element('titulo', $atributos, ''));
        $dataset->setDescripcion(element('descripcion', $atributos, ''));
        $dataset->setServicio($servicio);
        $dataset->setServicioCodigo($servicio->getCodigo());
        $dataset->updateCategorias($categorias);
        $dataset->setLicencia($licencia);
        $dataset->setMaestro(true);
        $dataset->setPublicado(element('publicado',$atributos,false));
        $dataset->setPublicadoAt(new \DateTime(element('fecha_publicacion',$atributos,'')));
        $dataset->setUpdatedAt(new \DateTime(element('fecha_actualizacion',$atributos,'')));
        $dataset->setCoordenadas(element('coordenadas',$atributos,''));
        $dataset->setDocId(element('doc_id', $atributos,''));

        foreach($nombresTags as $nombreTag){
            $tag = $this->_em->getRepository('Entities\Tag')->findOneByNombre($nombreTag);
            if(!$tag){
                $tag = new \Entities\Tag;
                $tag->setNombre($nombreTag);
                $tag->setUpdatedAt(new \DateTime());
                $tag->setCreatedAt(new \DateTime());

                $this->_em->persist($tag);
                $this->_em->flush();
            }
            $tags[] = $tag;
        }
        $dataset->updateTags($tags);

        $dataset->setCreatedAt(new \DateTime());

        return $dataset;
    }

    function actualizaRecursosDataset($dataset, $recursos){
        $atributos_recurso = array();

        if(is_array($recursos)){
            foreach ($recursos as $urlRecurso) {
                $recurso = $this->_em->getRepository('Entities\Recurso')->findOneBy(array('url' => $urlRecurso, 'dataset_id' => $dataset->getId()));
                if(!$recurso){
                    $atributos_recurso['url'] = $urlRecurso;
                    $atributos_recurso['descripcion'] = '';
                    $dataset->addRecurso($this->_em->getRepository('Entities\Recurso')->creaRecurso($atributos_recurso, $dataset));
                }
            }
        }else{
            $recurso = $this->_em->getRepository('Entities\Recurso')->findOneBy(array('url' => $recursos, 'dataset' => $dataset));
            if(!$recurso){
                $atributos_recurso['url'] = $recursos;
                $atributos_recurso['descripcion'] = '';
                $dataset->addRecurso($this->_em->getRepository('Entities\Recurso')->creaRecurso($atributos_recurso, $dataset));
            }
        }

        return $dataset;
    }

    public function migrarServicio(\Entities\Dataset $dataset, \Entities\Servicio $servicio_destino)
    {
        $dataset->setServicioCodigo($servicio_destino->getCodigo());
        $dataset->setServicio($servicio_destino);

        $this->_em->persist($dataset);
        $this->_em->flush();

        $dataset->generaVersion();

        return $dataset;
    }

    public function cambiarPublicacionUltimaVersion(\Entities\Dataset $datasetMaestro, $publicar = true)
    {
        $ultimaVersion = $datasetMaestro->getLastVersion();

        if(!$ultimaVersion->getPublicado() && $publicar) //Publica el dataset
            $ultimaVersion->togglePublicado();

        if($ultimaVersion->getPublicado() && !$publicar) //Despublica el dataset
            $ultimaVersion->togglePublicado();

        return $ultimaVersion;
    }

    public function getDatasetConPublicaciones($filtros = array()){

        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');

        $qb = $this->_em->createQueryBuilder();

        $qb->select('d', 's', 'e', 'dp')
            ->from('Entities\Dataset', 'd')
            ->leftJoin('d.primeraVersionPublicada', 'dp')
            ->leftJoin('d.servicio', 's')
            ->leftJoin('s.entidad', 'e')
            ->where('d.maestro = 1')
            ->where('dp.id IS NOT NULL')
            ->orderBy('dp.publicado_at', 'DESC');

        if(isset($filtros['anio']) && $filtros['anio']){
            $qb->andwhere('YEAR(dp.publicado_at) = :year');
            $qb->setParameter('year', $filtros['anio']);
        }

        if(isset($filtros['mes']) && $filtros['mes']){
            $qb->andwhere('MONTH(dp.publicado_at) = :month');
            $qb->setParameter('month', $filtros['mes']);
        }

        return $qb->getQuery()->getResult(2);

    }

}