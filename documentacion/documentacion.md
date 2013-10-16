## PRACTICA 1 : Creación y despliegue de una aplicación en un PaaS

Para el desarrollo de esta práctica he decidido usar [OpenShift](https://www.openshift.com/) , un PaaS de codigo abierto que permite
desplegar aplicaciones usando git. Además, en mi caso, he elegido openshift porque permite desarrollar aplicaciones en php.


### Explicación de la aplicación: Generador de objetivos

Al ver el sistema de evaluación de esta practica pensé en intentar desarrollar una aplicacion nueva que pudiera tener alguna 
utilidad para la asignatura. Es por ello que decidí hacer una aplicacion para generar el archivo de objetivos de la asignatura.
Para ello tan solo hay que marcar los ejercicios realizados hasta el momento y darle al boton generar, descargandose un archivo
objetivos.md con todos los objetivos, y con una x en aquellos que correspondadn a los ejercicios marcados. Cada ejercicio tiene 
asociado uno o dos objetivos que se cumplen al realizarlo. Esta asociación es simplemente bajo mi criterio y puede que no se
ajuste totalmente a los que el profesor establezca como objetivos superados para un determinado ejercicio.

### Crear una aplicacion php con OpenShift

Una vez decidido el lenguaje, el PaaS y la utildiad de la aplicación, el primer paso es entrar en [OpenShift](https://www.openshift.com/) y crear
nuestra aplicación. Si vamos siguiendo los pasos es muy facil, ya que solo hay que buscar el módulo de php y darle a crear aplicación.
Tras unos segundo tendremos la aplicación funcionando y nos aparecera la direccion de la misma. Una vez creada, se le pueden añadir 
"Cartridges" que son modulos que permiten añadir mas funcionalidades. En mi caso he añadido una base de datos mysql y phpmyadmin para 
gestionar esa base de datos a traves del navegador.

![captura](https://dl.dropboxusercontent.com/u/17453375/app.png)

Ahora necesitamos instalar algunos paquetes antes de continuar. Dando por hecho que tenemos instalado git, debemos seguir estos [pasos](https://www.openshift.com/developers/rhc-client-tools-install)
que hay en openshift para instalar rhc, una herramienta que nos permitira gestionar las opciones de openshift desde el terminal.
Por ultimo, solo nos queda descargar la aplicacion usando git. Necesitamos conocer la direccion en git para poder clonarlo. Tenemos
dos opciones:
		
		1.Desde openshift, podemos ir a nuestra aplicacion y buscar la direccion ssh.
		2.Con rhc podemos poner 'rhc app-show nombreaplicacion' y nos mostrará toda la información

Ya que la aplicación va a conectarse con una base de datos, es importante conocer la ip de la base de datos, la clave y la contraseña.
Estos datos los obtenemos con cualqueira de las dos opciones anteriores. Para la ip de la base de datos y el puerto podemos usar
'rhc port-forward -a nombredelaapp'.

Para descargar la aplicacion usamos git clone y la direccion ssh mencionada anteriormente y se nos clonará en la carpeta que estemos.
Para el desarrollo de la aplicacion solo tenemos que usar git add, git commit o git push tal y como ya conocemos. Ademas, creamos un 
repositorio en github obtenemos la direccion ssh y usamos las siguentes ordenes:

	git remote add 'alias' 'direccion ssh'
	git push 'alias' master

Con esto subimos al repositorio que queramos cambiando origin por el alias para enviarlo al repositorio de openshift o al repositorio
que acabamos de crear en github.

### Implementación de la aplicación

La aplicación es un documento html con codigo php que nos muestra una lista de ejercicios al lado de los cuales tenemos una checkbox 
para marcarlos. Cuando se seleccionan los archivos y se envia el formulario, el receptor es la propia pagina en la cual el codigo php
lee las opciones marcadas y busca en la base de datos los objetivos que se cumplen para cada objetivo marcado. Para la conexion a la
base de datos uso la interfaz PDO para mysql de php. Usando los datos del punto anterior creo la conexion y consulto la base de datos.
Una vez tengo los objetivos, recorro un documento que tiene ya todos los objetivos pero sin marcar, y pongo una x en los que se cumplen.
Cuando se marcan todos se fuerza una descarga del documento cuyo nombre es 'objetivos.md'.
El código es corto y esta comentado por lo que no se detalla mas en este documento. 

En la siguiente imagen podemos ver el aspecto de la aplicacion.

![captura](https://dl.dropboxusercontent.com/u/17453375/aplicacion.png)

En principio solo estan reflejados los ejercicios y objetivos de los dos primeros temas aunque es muy facil hacer una ampliación en el
futuro para añadir el resto de temas y objetivos.

### Direccion de la aplicacion

* Aplicacion: [http://generadordeobjetivos-gii.rhcloud.com/](http://generadordeobjetivos-gii.rhcloud.com/) 
* Practica: [https://github.com/torresj/practica-1](https://github.com/torresj/practica-1)
* Documentación: [https://github.com/torresj/practica-1/blob/master/documentacion/documentacion.md](https://github.com/torresj/practica-1/blob/master/documentacion/documentacion.md)

###Biliografía
	
* [https://www.openshift.com/developers/rhc-client-tools-install](https://www.openshift.com/developers/rhc-client-tools-install)
* [http://xmeele.wordpress.com/2013/03/27/guia-completa-de-openshift-de-red-hat-para-principiantes-windows/](http://xmeele.wordpress.com/2013/03/27/guia-completa-de-openshift-de-red-hat-para-principiantes-windows/)
* [http://www.php.net/manual/es/](http://www.php.net/manual/es/)
* [http://diariolinux.com/2012/01/25/openshift-computacion-gratuita-en-la-nube-de-redhat/](http://diariolinux.com/2012/01/25/openshift-computacion-gratuita-en-la-nube-de-redhat/)

