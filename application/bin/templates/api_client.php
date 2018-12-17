<?php echo "<?php\n"; ?>
/**
 * Generated automatically through the api client generator
 * @created    <?php echo date('r')."\n"; ?>
 */

require_once APPPATH . 'libraries/Api.php';
class <?php echo $apiName; ?>
{
	private $_ci;
    private $_api;
    
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->config->load('config_services', true, true);
        $arrServices = $this->_ci->config->item('config_services');
        $this->_api = new Api($arrServices['services']['<?php echo strtolower($apiController) ?>']);
    }
    
<?php 
    $className = $apiController;
    foreach ($objSelectedApiController->getMethods() as $method) {
        $method = $method->getName();
        if ($method[0] !== '_' && (strpos($method,'_get') || strpos($method,'_put') || strpos($method,'_delete') || strpos($method,'_post'))) 
        {
    ?>
	<?php 
    $objReflectionMethod = new ReflectionMethod($className, $method);
    $comment = $objReflectionMethod->getDocComment();
    echo $comment . "\n";
    
    $http_method = (strpos($method, '_post')) ? 'true' : 'false'; 
    $uri_method = str_replace(array('_get', '_put', '_post', 'delete'), '', $method);
	?>
    public function <?php echo $method; ?>($params = array(), $format = 'json')
    {
    	return $this->_api->fetch('<?php echo $className . '/' . $uri_method?>', $params, <?php echo $http_method?>, $format);
    }
<?php 
    } // if - put/get/delete
    } // foreach method ?>
}
