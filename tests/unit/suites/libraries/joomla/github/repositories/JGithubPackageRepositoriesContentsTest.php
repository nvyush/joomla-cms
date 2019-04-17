<?php
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-01 at 14:30:39.
 */
class JGithubPackageRepositoriesContentsTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @var    JRegistry  Options for the GitHub object.
	 * @since  2.5.0
	 */
	protected $options;

	/**
	 * @var    JGithubHttp  Mock client object.
	 * @since  2.5.0
	 */
	protected $client;

	/**
	 * @var    JHttpResponse  Mock response object.
	 * @since  3.1.4
	 */
	protected $response;

	/**
	 * @var JGithubPackageRepositoriesContents
	 */
	protected $object;

	/**
	 * @var    string  Sample JSON string.
	 * @since  3.1.4
	 */
	protected $sampleString = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

	/**
	 * @var    string  Sample JSON error message.
	 * @since  3.1.4
	 */
	protected $errorString = '{"message": "Generic Error"}';

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @since   ¿
	 *
	 * @return  void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->options  = new JRegistry;
		$this->client   = $this->getMockBuilder('JGithubHttp')->setMethods(array('get', 'post', 'delete', 'patch', 'put'))->getMock();
		$this->response = $this->getMockBuilder('JHttpResponse')->getMock();

		$this->object = new JGithubPackageRepositoriesContents($this->options, $this->client);
	}

	/**
	 * @covers JGithubPackageRepositoriesContents::getReadme
	 */
	public function testGetReadme()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/readme')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getReadme('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesContents::getReadme
	 */
	public function testGetReadmeRef()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/readme?ref=123abc')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getReadme('joomla', 'joomla-platform', '123abc'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesContents::get
	 */
	public function testGet()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/contents/path/to/file.php')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', 'path/to/file.php'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesContents::get
	 */
	public function testGetRef()
	{
		$this->response->code = 200;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/contents/path/to/file.php?ref=123abc')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->get('joomla', 'joomla-platform', 'path/to/file.php', '123abc'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesContents::getArchiveLink
	 */
	public function testGetArchiveLink()
	{
		$this->response->code = 302;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/zipball')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getArchiveLink('joomla', 'joomla-platform'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesContents::getArchiveLink
	 */
	public function testGetArchiveLinkRef()
	{
		$this->response->code = 302;
		$this->response->body = $this->sampleString;

		$this->client->expects($this->once())
			->method('get')
			->with('/repos/joomla/joomla-platform/zipball?ref=123abc')
			->will($this->returnValue($this->response));

		$this->assertThat(
			$this->object->getArchiveLink('joomla', 'joomla-platform', 'zipball', '123abc'),
			$this->equalTo(json_decode($this->sampleString))
		);
	}

	/**
	 * @covers JGithubPackageRepositoriesContents::getArchiveLink
	 *
	 * @expectedException UnexpectedValueException
	 */
	public function testGetArchiveLinkInvalidFormat()
	{
		$this->response->code = 302;
		$this->response->body = $this->sampleString;

			$this->object->getArchiveLink('joomla', 'joomla-platform', 'invalid');
	}
}
