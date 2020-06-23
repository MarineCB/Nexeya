
<?php
function init_user_session(): bool
{
    if(!session_id()){
        session_start();
        session_regenerate_id();
        return true;
    }
    return false;
}

function close_user_session(): bool
{
    if(!session_id()){
        session_start();
        session_unset();#enleve tous les contenus mémorisés
        session_destroy();
        return true;
    }
    return false;
}

function redirect($controller,$method= "",$args = array())
{
    global $core; /* Guess Obviously */
	if(empty($method))
		$location = $core->config->base_url. "/Nexeya/" . $controller  . implode("/",$args);
	else
		$location = $core->config->base_url. "/Nexeya/" . $controller . "/" . $method . "/" . implode("/",$args);

    header("Location: " . $location);
    exit;
}

function isAdmin(){
	return isset($_SESSION['userStatus']) && !empty($_SESSION['userStatus']) && ($_SESSION['userStatus'] == 'admin');
}

function isSalesman(){
    return isset($_SESSION['userStatus']) && !empty($_SESSION['userStatus']) && ($_SESSION['userStatus'] == 'commercial');
}

function isSalesmanager(){
    return isset($_SESSION['userStatus']) && !empty($_SESSION['userStatus']) && ($_SESSION['userStatus'] == 'responsable-commercial');
}

function isMeca(){
    return isset($_SESSION['userStatus']) && !empty($_SESSION['userStatus']) && ($_SESSION['userStatus'] == 'meca');
}
