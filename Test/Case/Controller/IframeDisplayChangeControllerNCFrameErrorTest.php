<?php
/**
 * IframeDisplayChangeControllerLoginUser Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('IframesController', 'Iframes.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * IframeDisplayChangeControllerNCFrameError Test Case
 *
 * @author Kotaro Hokada <kotaro.hokada@gmail.com>
 * @package NetCommons\Iframes\Test\Case\Controller
 */
class IframeDisplayChangeControllerNCFrameErrorTest extends ControllerTestCase {

/**
 * mock controller object
 *
 * @var Controller
 */
	public $Controller = null;

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'site_setting',
		'plugin.iframes.iframe',
		'plugin.iframes.iframe_frame_setting',
		'plugin.iframes.block',
		'plugin.iframes.frame',
		'plugin.iframes.plugin',
		'plugin.frames.box',
		'plugin.frames.language',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.user',
		'plugin.roles.default_role_permission',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
		$this->login();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		$this->logout();
		Configure::write('Config.language', null);
		parent::tearDown();
	}

/**
 * login　method
 *
 * @return void
 */
	public function login() {
		//ログイン処理
		$this->Controller = $this->generate('Iframes.IframeDisplayChange', array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
				'Security',
				'RequestHandler',
				'NetCommons.NetCommonsFrame',
			),
		));

		$this->Controller->NetCommonsFrame
			->staticExpects($this->any())
			->method('setView')
			->will($this->returnValue(false));

		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(array($this, 'authUserCallback')));

		$this->Controller->Auth->login(array(
				'username' => 'admin',
				'password' => 'admin',
				'role_key' => 'system_administrator',
			)
		);
		$this->assertTrue($this->Controller->Auth->loggedIn(), 'login');
	}

/**
 * logout method
 *
 * @return void
 */
	public function logout() {
		//ログアウト処理
		$this->Controller->Auth->logout();
		$this->assertFalse($this->Controller->Auth->loggedIn(), 'logout');

		CakeSession::write('Auth.User', null);
		unset($this->Controller);
	}

/**
 * authUserCallback method
 *
 * @return array user
 */
	public function authUserCallback() {
		$user = array(
			'id' => 1,
			'username' => 'admin',
			'role_key' => 'system_administrator',
		);
		CakeSession::write('Auth.User', $user);
		return $user;
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$this->setExpectedException('ForbiddenException');
		$this->testAction('/iframes/iframe_display_change/view/1', array('method' => 'get'));
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
		$postData = array(
			'IframeFrameSetting' => array(
				'id' => '1',
				'heiht' => '400',
				'display_scrollbar' => '1',
				'display_frame' => '1',
				'frame_key' => 'frame_1',
			)
		);

		$this->setExpectedException('ForbiddenException');
		$this->testAction('/iframes/iframe_display_change/edit/1.json',
			array(
				'method' => 'post',
				'data' => $postData
			)
		);
	}

}