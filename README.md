# Slim Framework 3 Skeleton Application

Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3 with the PHP-View template renderer. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    php composer.phar create-project slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can run these commands 

	cd [my-app-name]
	php composer.phar start

Run this command in the application directory to run the test suite

	php composer.phar test

That's it! Now go build something cool.


#Proyecto 

# Si al mozo le hacen un pedido (POST comandas/) de un vino , una cerveza y unas empanadas, deberían los
empleados correspondientes ver estos pedidos en su listado de “pendientes” (GET pedidos/pendientes). Con la opción de tomar una foto de la mesa con sus integrantes y relacionarlo con el pedido.

#al mozo se le da un código único alfanumérico de 5 caracteres al cliente que le permite
identificar su pedido ( LEYENDO EL RESPONSE )

POST comandas/tomar
REQUEST
{
	{
	codigo_mesa: 12345,
	nombre_cliente: "tito",
	foto: null,
	pedidos:[
		{
			alimento_id: 1
			cantidad: 3
		},
		{
			alimento_id: 2
			cantidad: 2
		},
		{
			alimento_id: 9
			cantidad: 1
		},
		{
			alimento_id: 10
			cantidad: 2
		}
	]
}
}
RESPONSE : 
{
	response: {
		"Comanda creada , codigo : {COMANDA_CODIGO}"
	},
	data:{		
		comandaCodigo: COMANDA_CODIGO
	}
}

GET comandas/pendientes
RESPONSE : 
{
	data:[
		{
			alimento:
			cantidad:			
		}
	]
}


# El empleado que tomar ese pedido para prepararlo, al momento de hacerlo debe cambiar el
estado de ese pedido como “en preparación” y agregarle un tiempo  (en minutos ) estimado de preparación.
teniendo en cuenta que puede haber más de un empleado en el mismo puesto .ej: dos bartender
o tres cocineros ( el usuario loguedao determina si es posible hacerlo )

POST  pedidos/preparar 
{
	pedido_id: 1 
	tiempo_estimado: 30 
}


# El empleado que tomar ese pedido para prepararlo debe poner el estado “listo para servir”,
cuando el pedido está listo.

POST  pedido/alaorden 
{
	pedido_id: 1 	
}

# Cualquiera de los socios pude ver en todo momento el estado de todos los pedidos. ( dependiendo del usuario ve todos o ve solo los que puede llegar a tomar , el socio puede ver todo )

GET pedidos/
RESPONSE : 
{
	data:[
		{
			alimento:
			cantidad:
			estado:
		}
	]
}

#Las mesas tiene un código de identificación único de 5 caracteres , el cliente al entrar en nuestra
aplicación puede ingresar ese código junto con el del pedido y se le mostrará el tiempo restante
para su pedido.
GET comandas/estimado
REQUEST
{
	mesaCodigo:
	comandaCodigo:
}
RESPONSE 
{
	response: "Su pedido estaria listo en {MINUTOS} minutos" | "su pedido esta retrazado en {MINUTOS}  
	data:{
		alimento:
		cantidad:
	}
}



# La mesa se puede estar con estos estados “con cliente esperando pedido” ,”con clientes
comiendo” (al entregar el mozo llama a PUT mesas/comiendo) “con clientes pagando” (al entregar el ticket el mozo llama a PUT mesas/pagando ) y “cerrada” (al cobrar el socio llama a PUT mesas/cerrar) cierra cuando el cliente se retira y la acción de
cambiar el estado a “cerrada” la realiza únicamente uno de los socios. Los estados anteriores son
cambiados por el mozo.

PUT mesas/cerrar
REQUEST
{
	codigoMesa:
}

PUT mesas/comiendo
REQUEST
{
	codigoMesa:
}

PUT mesas/pagando
REQUEST
{
	codigoMesa:
}

#Al terminar de comer se habilita una encuesta con una puntuación del 1 al 10
POST encuestas/
REQUEST
{
	codigoMesa:
	comentario:""
	laMesa:10
	elRestaurante:10
	elMozo:10
	elCocinero:10
}
RESPONSE 
{
	response:"Gracias, su opinion nos ayuda a mejorar"
}

