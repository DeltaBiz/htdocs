<?
//module/Auth/Module.php
namespace Auth;
 
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
 
class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig(){/*common code*/}
    public function getConfig(){ /*common code*/}
     
    public function getServiceConfig()
    {
        return array(
            'factories'=>array(
        	'Auth\Model\MyAuthStorage' => function($sm){
            	return new \Auth\Model\MyAuthStorage('zf_tutorial');  
        },
         
        'AuthService' => function($sm) {
                    //My assumption, you've alredy set dbAdapter
                    //and has users table with columns : user_name and pass_word
                    //that password hashed with md5
            $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 
                                              'users','username','password', 'MD5(?)');
             
            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($sm->get('Auth\Model\MyAuthStorage'));
              
            return $authService;
        },
            ),
        );
    }
 
}
?>