# Definición de Recursos:

## Dataset:

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>id</td>
    <td>número</td>
    <td>Identificador del dataset</td>
  </tr>
  <tr>
    <td>titulo</td>
    <td>texto</td>
    <td>Tíulo del dataset</td>
  </tr>
  <tr>
    <td>descripcion</td>
    <td>texto</td>
    <td>Descripción del dataset</td>
  </tr>
  <tr>
    <td>licencia</td>
    <td>objeto</td>
    <td>Licencia asociada al dataset</td>
  </tr>
  <tr>
    <td>servicio</td>
    <td>objeto</td>
    <td>Objeto de tipo servicio</td>
  </tr>
  <tr>
    <td>categorias</td>
    <td>arreglo</td>
    <td>Listado de tipo categoria</td>
  </tr>
  <tr>
    <td>recursos</td>
    <td>arreglo</td>
    <td>Listado de tipo recurso</td>
  </tr>
  <tr>
    <td>tags</td>
    <td>csv</td>
    <td>Tags asociados al dataset</td>
  </tr>
  <tr>
    <td>fecha_publicacion</td>
    <td>texto (yyyy-mm-dd)</td>
    <td>Fecha de publicación del dataset</td>
  </tr>
  <tr>
    <td>fecha_actualizacion</td>
    <td>texto (yyyy-mm-dd)</td>
    <td>Fecha de actualización del dataset</td>
  </tr>
  <tr>
    <td>coordenadas</td>
    <td>texto</td>
    <td>Coordenadas geográficas asociadas al dataset</td>
  </tr>
  <tr>
    <td>doc_id</td>
    <td>texto</td>
    <td>Identificador del dataset en el geo-portal</td>
  </tr>
  <tr>
    <td>frecuencia</td>
    <td>texto</td>
    <td>Frecuencia con que se actualiza el dataset, es un campo de texto libre (anual, mensual, semanal, etc)</td>
  </tr>
  <tr>
    <td>granularidad</td>
    <td>text</td>
    <td>Nivel de detalles del dataset, texto libre explicativo</td>
  </tr>
  <tr>
    <td>cobertura_temporal</td>
    <td>texto</td>
    <td>Tiempo durante el cual los datos fueron capturado o estarán vigentes, es un campo de texto libre.</td>
  </tr>
</table>


## Recurso:

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>id</td>
    <td>numero</td>
    <td>Identificador del recurso</td>
  </tr>
  <tr>
    <td>descripcion</td>
    <td>texto [ - ]</td>
    <td>Descripción del recurso</td>
  </tr>
  <tr>
    <td>url</td>
    <td>texto [ 255 ]</td>
    <td>Url donde se encuentra el recurso</td>
  </tr>
  <tr>
    <td>mime</td>
    <td>texto [ 255 ]</td>
    <td>Mime type del recurso</td>
  </tr>
  <tr>
    <td>size</td>
    <td>numero [ 11 ]</td>
    <td>tamaño del recurso (bytes)</td>
  </tr>
  <tr>
    <td>vistas_junar</td>
    <td>arreglo</td>
    <td>Listado de vistas_junar</td>
  </tr>
</table>


## Vistas Junar:

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>guid</td>
    <td>numero</td>
    <td>GUID de la vista en junar</td>
  </tr>
  <tr>
    <td>recurso_id</td>
    <td>numero</td>
    <td>Id del recurso al que se asociará la vista</td>
  </tr>
  <tr>
    <td>title</td>
    <td>texto [ 255 ]</td>
    <td>Títlo de la vista</td>
  </tr>
  <tr>
    <td>description</td>
    <td>texto [ - ] </td>
    <td>Descripción de la vista</td>
  </tr>
  <tr>
    <td>category</td>
    <td>texto [ 255 ]</td>
    <td>Categoría de la vista</td>
  </tr>
  <tr>
    <td>tags</td>
    <td>csv</td>
    <td>Etiquetas de la vista</td>
  </tr>
  <tr>
    <td>source</td>
    <td>texto [ 255 ]</td>
    <td>Url con la fuente de datos de la vista</td>
  </tr>
  <tr>
    <td>meta_data</td>
    <td>texto [ 255 ]</td>
    <td>Metada data adicional de la vista, actualmente contiene el Id del dataset al que pertenece la vista</td>
  </tr>
  <tr>
    <td>table_id</td>
    <td>numero</td>
    <td>Identificador de página del documento de donde provienen los datos</td>
  </tr>
</table>


## Categoría:

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>id</td>
    <td>numero</td>
    <td>Identificador de la categoría</td>
  </tr>
  <tr>
    <td>nombre</td>
    <td>texto [ 255 ]</td>
    <td>Nombre de la categoría</td>
  </tr>
</table>


## Servicio:

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>codigo</td>
    <td>texto [ 255 ]</td>
    <td>Código del servicio</td>
  </tr>
  <tr>
    <td>nombre</td>
    <td>texto [ 255 ]</td>
    <td>Nombre del servicio</td>
  </tr>
  <tr>
    <td>sigla</td>
    <td>texto [ 255 ]</td>
    <td>Sigla del servicio</td>
  </tr>
  <tr>
    <td>url</td>
    <td>texto [ 255 ]</td>
    <td>Url de la web oficial del servicio</td>
  </tr>
  <tr>
    <td>servicio_padre</td>
    <td>recurso Institución</td>
    <td>Objeto tipo institución</td>
  </tr>
</table>


## Institución:

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>codigo</td>
    <td>texto [ 255 ]</td>
    <td>Código de la institución</td>
  </tr>
  <tr>
    <td>nombre</td>
    <td>texto [ 255 ]</td>
    <td>Nombre de la institución</td>
  </tr>
  <tr>
    <td>sigla</td>
    <td>texto [ 255 ]</td>
    <td>Sigla de la institución</td>
  </tr>
</table>


# Descripción de métodos disponibles en la Api:

## Creación de nuevo Datasets:

**Url Api:** /api/v2/datasets

**Metodo:** Post

**Campos (* requeridos):**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>*titulo</td>
    <td>texto [255]</td>
    <td>Título del dataset</td>
  </tr>
  <tr>
    <td>*descripcion</td>
    <td>texto [ - ]</td>
    <td>Descripción del dataset</td>
  </tr>
  <tr>
    <td>*servicio</td>
    <td>texto [255]</td>
    <td>Código del servicio al que pertenece el dataset (ver endpoint de servicios)</td>
  </tr>
  <tr>
    <td>*categoria</td>
    <td>csv</td>
    <td>CSV con los ids de las categorías a las que pertenece el dataset</td>
  </tr>
  <tr>
    <td>tags</td>
    <td>csv</td>
    <td>CSV con los nombres de los tags asociados al dataset</td>
  </tr>
  <tr>
    <td>coordenadas</td>
    <td>csv</td>
    <td>CSV con las coordenadas del dataset en formato lat, lng</td>
  </tr>
  <tr>
    <td>frecuencia</td>
    <td>texto [255]</td>
    <td>Frecuencia con que se actualiza el dataset, es un campo de texto libre (anual, mensual, semanal, etc)</td>
  </tr>
  <tr>
    <td>granularidad</td>
    <td>texto [255]</td>
    <td>Nivel de detalles del dataset, texto libre explicativo</td>
  </tr>
  <tr>
    <td>cobertura_temporal</td>
    <td>texto [255]</td>
    <td>Tiempo durante el cual los datos fueron capturado o estarán vigentes, es un campo de texto libre.</td>
  </tr>
</table>


**Respuesta (JSON):**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>meta</td>
    <td>objeto</td>
    <td>Contiene información sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.error</td>
    <td>boolean</td>
    <td>Indica si ha ocurrido un error en la consulta</td>
  </tr>
  <tr>
    <td>meta.messages</td>
    <td>arreglo</td>
    <td>Listado de mensajes sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>item</td>
    <td>objeto | null</td>
    <td>recurso de tipo dataset</td>
  </tr>
</table>


## Creación de recurso:

**Url Api:** /api/v2/recursos

**Metodo:** Post

**Campos (* requeridos):**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>*dataset_id</td>
    <td>numero</td>
    <td>Identificador del dataset al que se asignará el recurso</td>
  </tr>
  <tr>
    <td>*url</td>
    <td>texto [ 255 ]</td>
    <td>Url donde se encuentra el recurso</td>
  </tr>
  <tr>
    <td>descripcion</td>
    <td>texto [ - ]</td>
    <td>Descripción del recurso</td>
  </tr>
  <tr>
    <td>mime</td>
    <td>texto [ 255 ]</td>
    <td>Mime type del recurso</td>
  </tr>
  <tr>
    <td>size</td>
    <td>numero [ 11 ]</td>
    <td>tamaño del recurso (bytes)</td>
  </tr>
</table>


# Respuesta (JSON):

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>meta</td>
    <td>objeto</td>
    <td>Contiene información sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.error</td>
    <td>boolean</td>
    <td>Indica si ha ocurrido un error en la consulta</td>
  </tr>
  <tr>
    <td>meta.messages</td>
    <td>arreglo</td>
    <td>Listado de mensajes sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>item</td>
    <td>objeto | null</td>
    <td>recurso de tipo recurso</td>
  </tr>
</table>


## Creación de Vista Junar:

**Url:** api/v2/vista_junar

**Metodo:** Post

**Campos (* Requeridos )**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>*guid</td>
    <td>numero</td>
    <td>GUID de la vista en junar</td>
  </tr>
  <tr>
    <td>*title</td>
    <td>texto [ 255 ]</td>
    <td>Títlo de la vista</td>
  </tr>
  <tr>
    <td>*description</td>
    <td>texto [ - ] </td>
    <td>Descripción de la vista</td>
  </tr>
  <tr>
    <td>*category</td>
    <td>texto [ 255 ]</td>
    <td>Categoría de la vista</td>
  </tr>
  <tr>
    <td>*tags</td>
    <td>csv</td>
    <td>Etiquetas de la vista</td>
  </tr>
  <tr>
    <td>*source</td>
    <td>texto [ 255 ]</td>
    <td>Url con la fuente de datos de la vista</td>
  </tr>
  <tr>
    <td>*recurso_id</td>
    <td>numero</td>
    <td>Identificador del recurso al que se asignará la vista</td>
  </tr>
  <tr>
    <td>table_id</td>
    <td>numero</td>
    <td>Identificador de página del documento de donde provienen los datos</td>
  </tr>
</table>


## Obtener Datasets:

**Url:** api/v2/datasets

**Metodo:** Get

**Filtros de búsqueda:**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>servicio_codigo</td>
    <td>texto [ 255 ]</td>
    <td>Código del servicio al que pertenece el dataset</td>
  </tr>
</table>


**Respuesta (Json):**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>meta</td>
    <td>objeto</td>
    <td>Contiene información sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.error</td>
    <td>boolean</td>
    <td>Indica si ha ocurrido un error en la consulta</td>
  </tr>
  <tr>
    <td>meta.messages</td>
    <td>arreglo</td>
    <td>Listado de mensajes sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.total</td>
    <td>numero</td>
    <td>Total de registros encontrados</td>
  </tr>
  <tr>
    <td>meta.limit</td>
    <td>numero</td>
    <td>Cantidad máxima de registros a entregar por la consulta</td>
  </tr>
  <tr>
    <td>meta.offset</td>
    <td>numero</td>
    <td>Registro desde el cual se comenzará el listado de registros </td>
  </tr>
  <tr>
    <td>items</td>
    <td>array | null</td>
    <td>Listado de recursos tipo dataset</td>
  </tr>
</table>


## Obtener Servicios:

**Url:** api/v2/servicios

**Metodo:** Get

**Filtros de búsqueda:**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>codigo</td>
    <td>texto [ 255 ]</td>
    <td>Código del servicio</td>
  </tr>
  <tr>
    <td>entidad_codigo</td>
    <td>texto [ 255 ]</td>
    <td>Código de la institución a la que pertenece el servicio (Normalmente son las 2 primeras letras del código)</td>
  </tr>
</table>


**Respuesta (Json):**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>meta</td>
    <td>objeto</td>
    <td>Contiene información sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.error</td>
    <td>boolean</td>
    <td>Indica si ha ocurrido un error en la consulta</td>
  </tr>
  <tr>
    <td>meta.messages</td>
    <td>arreglo</td>
    <td>Listado de mensajes sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.total</td>
    <td>numero</td>
    <td>Total de registros encontrados</td>
  </tr>
  <tr>
    <td>meta.limit</td>
    <td>numero</td>
    <td>Cantidad máxima de registros a entregar por la consulta</td>
  </tr>
  <tr>
    <td>meta.offset</td>
    <td>numero</td>
    <td>Registro desde el cual se comenzará el listado de registros </td>
  </tr>
  <tr>
    <td>items</td>
    <td>array | null</td>
    <td>Listado de recursos tipo servicio</td>
  </tr>
</table>


## Obtener Instituciones:

## **Url:** api/v2/instituciones

## **Metodo:** Get

## **Filtros de búsqueda:**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>codigo</td>
    <td>texto [ 255 ]</td>
    <td>Código del servicio</td>
  </tr>
</table>


## **Respuesta (Json):**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>meta</td>
    <td>objeto</td>
    <td>Contiene información sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.error</td>
    <td>boolean</td>
    <td>Indica si ha ocurrido un error en la consulta</td>
  </tr>
  <tr>
    <td>meta.messages</td>
    <td>arreglo</td>
    <td>Listado de mensajes sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.total</td>
    <td>numero</td>
    <td>Total de registros encontrados</td>
  </tr>
  <tr>
    <td>meta.limit</td>
    <td>numero</td>
    <td>Cantidad máxima de registros a entregar por la consulta</td>
  </tr>
  <tr>
    <td>meta.offset</td>
    <td>numero</td>
    <td>Registro desde el cual se comenzará el listado de registros </td>
  </tr>
  <tr>
    <td>items</td>
    <td>array | null</td>
    <td>Listado de recursos tipo institución</td>
  </tr>
</table>


## Obtener Categorias:

**Url:** api/v2/categorias

**Metodo:** Get

**Respuesta (Json):**

<table>
  <tr>
    <td>Campo</td>
    <td>Tipo</td>
    <td>Descripción</td>
  </tr>
  <tr>
    <td>meta</td>
    <td>objeto</td>
    <td>Contiene información sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.error</td>
    <td>boolean</td>
    <td>Indica si ha ocurrido un error en la consulta</td>
  </tr>
  <tr>
    <td>meta.messages</td>
    <td>arreglo</td>
    <td>Listado de mensajes sobre el resultado de la consulta</td>
  </tr>
  <tr>
    <td>meta.total</td>
    <td>numero</td>
    <td>Total de registros encontrados</td>
  </tr>
  <tr>
    <td>meta.limit</td>
    <td>numero</td>
    <td>Cantidad máxima de registros a entregar por la consulta</td>
  </tr>
  <tr>
    <td>meta.offset</td>
    <td>numero</td>
    <td>Registro desde el cual se comenzará el listado de registros </td>
  </tr>
  <tr>
    <td>items</td>
    <td>array | null</td>
    <td>Listado de recursos tipo categoría</td>
  </tr>
</table>