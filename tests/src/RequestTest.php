<?php

namespace tests\src;

use Yii;
use luya\helpers\Url;

/**
 * 
 * @author nadar
 *
 */
class RequestTest extends \tests\BaseTest
{
    public $urlRules = [
        ['pattern' => 'news/detail/<id:\d+>/<title:[a-zA-Z0-9\-]+>/', 'route' => 'news/default/detail'],
        ['pattern' => 'news/global-test/<id:\d+>/', 'route' => 'news/test', 'composition' => 
            [
                'fr' => 'news/french-test/<id:\d+>/',
                'en' => 'news/english-test/<id:\d+>/',
                'de' => 'news/deutsch-test/<id:\d+>/',
            ]   
        ]
    ];
    
    public function setUp()
    {
        parent::setUp();
        Yii::$app->composition->setKey('langShortCode', 'en');
    }
    
    public function testBasicRequest()
    {
        $urlManager = new \luya\components\UrlManager();
        $urlManager->addRules($this->urlRules);
        
        $request = new \yii\web\Request();
        $request->pathInfo = 'news/detail/1/foo-bar';
        
        $r = $urlManager->parseRequest($request);
        
        $this->assertArrayHasKey(0, $r);
        $this->assertArrayHasKey(1, $r);
        
        $this->assertArrayHasKey("id", $r[1]);
        $this->assertArrayHasKey("title", $r[1]);
        
        $this->assertEquals("news/default/detail", $r[0]);
        
        $this->assertEquals("1", $r[1]['id']);
        $this->assertEquals("foo-bar", $r[1]['title']);
    }
    
    public function testCompositionRequest()
    {
        $urlManager = new \luya\components\UrlManager();
        $urlManager->addRules($this->urlRules);
        
        $request = new \yii\web\Request();
        $request->pathInfo = 'news/english-test/1';
        
        $r = $urlManager->parseRequest($request);
        
        $this->assertArrayHasKey(0, $r);
        $this->assertArrayHasKey(1, $r);
        
        $this->assertArrayHasKey("id", $r[1]);
        
        $this->assertEquals("news/test", $r[0]);
        
        $this->assertEquals("1", $r[1]['id']);
    }
}