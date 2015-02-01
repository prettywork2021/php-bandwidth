<?php
/**
 * @model Recording
 * https://catapult.inetwork.com/docs/api-docs/recording/
 *
 * Recordings for calls.
 */
namespace Catapult;

final class Recording extends GenericResource {

    /**
     * CTor for recordings
     *
     * Init Forms:
     * GET
     * Recording('recording-id')
     *
     * POST
     * Recording(array)
     */
    public function __construct($args=null) {
        $data = Ensure::Input($args);
        parent::_init($data, new DependsResource,
            new LoadsResource(
                array("primary" => "GET", "id" => "id", "init" => "", "silent" => false)
            ),
            new SchemaResource(
                array("fields" => array("id", "call", "endTime", "media", "startTime", "state", "page", "size"), "needs" => array("id"))
            ),
            new SubFunctionResource(array(
                array("term" => "transcriptions", "type" => "get", "plural" => true) 
            ))
        );
    }

	/**
	 * Download a media file
	 * provided the content type
	 * on successful response of content type
	 * header
	 */	
	public function getMediaFile()
	{
		$content = $this->client->get($this->media, array(), FALSE);

		return new Media($content, $this->media);
	}
}
?>