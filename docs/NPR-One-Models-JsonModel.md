NPR\One\Models\JsonModel
===============

A thin abstraction to aide in transforming raw JSON into a model, yet allowing it to be re-encoded as JSON when
stringified.




* Class name: JsonModel
* Namespace: NPR\One\Models
* This is an **abstract** class







Methods
-------


### __construct

    mixed NPR\One\Models\JsonModel::__construct($json)

Model constructor.



* Visibility: **public**


#### Arguments
* $json **mixed**



### __toString

    string NPR\One\Models\JsonModel::__toString()

Re-encodes the original JSON model as a string and returns it.



* Visibility: **public**



