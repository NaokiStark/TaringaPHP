# TaringaPHP

# Esto se murio junto con Taringa, Rest In Peace

Api no oficial en PHP

# Acerca de esto

Lo hice porque al pedo.

## Métodos

sendShout($body,$attach=0,$attach_url='',$privacy=1);

getComments($id); //$id= Id del shout

getShout($id) //$id= Id del shout

sendComment($sId,$body,$cId=null) //$sId = id del shout, $body = cuerpo del comentario, $cId= en caso de querer responder comentario, agregar el id del comentario padre

getNotify(); //obtiene la cantidad de notificaciones de un usuario en formato json: "{"newsfeed":0,"notification":0,"thirdnotification":0,"friendsfeed":0,"mention":0,"messages":0}"

getNewsFeed(); //obtiene los ultimos shouts *en html*

voteShout($uid,$ownerid) // Votar shout. $uid = id del shout, $ownerid= id del creador del shout

getNotifications(); // ultimas 5 notificaciones en formato json
## Uso

Ver el archivo test.php para un ejemplo
