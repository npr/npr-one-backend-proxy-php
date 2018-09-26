<?php

namespace NPR\One\Models;


/**
 * A thin abstraction to aide in transforming raw JSON into a model, yet allowing it to be re-encoded as JSON when
 * stringified.
 *
 * @package NPR\One\Models
 */
abstract class JsonModel
{
    /** @var \stdClass - the original json used to construct this model, useful for debugging
      * @internal */
    protected $originalJsonObject;

    /**
     * Model constructor.
     *
     * @param $json
     * @throws \Exception
     */
    public function __construct($json)
    {
        $this->originalJsonObject = json_decode($json);
        if (!$this->originalJsonObject instanceof \stdClass)
        {
            throw new \Exception('Model cannot be json_decoded: ' . print_r($json, 1));
        }
    }

    /**
     * Re-encodes the original JSON model as a string and returns it.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->originalJsonObject);
    }
}
