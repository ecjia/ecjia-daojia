<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage\Handler;

/**
<<<<<<< HEAD
 * MongoDB session handler.
 *
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 */
class MongoDbSessionHandler implements \SessionHandlerInterface
{
    /**
     * @var \Mongo|\MongoClient|\MongoDB\Client
     */
    private $mongo;

    /**
     * @var \MongoCollection
=======
 * Session handler using the mongodb/mongodb package and MongoDB driver extension.
 *
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 *
 * @see https://packagist.org/packages/mongodb/mongodb
 * @see https://php.net/mongodb
 */
class MongoDbSessionHandler extends AbstractSessionHandler
{
    private $mongo;

    /**
     * @var \MongoDB\Collection
>>>>>>> v2-test
     */
    private $collection;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor.
     *
     * List of available options:
     *  * database: The name of the database [required]
     *  * collection: The name of the collection [required]
     *  * id_field: The field name for storing the session id [default: _id]
     *  * data_field: The field name for storing the session data [default: data]
     *  * time_field: The field name for storing the timestamp [default: time]
<<<<<<< HEAD
     *  * expiry_field: The field name for storing the expiry-timestamp [default: expires_at]
=======
     *  * expiry_field: The field name for storing the expiry-timestamp [default: expires_at].
>>>>>>> v2-test
     *
     * It is strongly recommended to put an index on the `expiry_field` for
     * garbage-collection. Alternatively it's possible to automatically expire
     * the sessions in the database as described below:
     *
     * A TTL collections can be used on MongoDB 2.2+ to cleanup expired sessions
     * automatically. Such an index can for example look like this:
     *
     *     db.<session-collection>.ensureIndex(
     *         { "<expiry-field>": 1 },
     *         { "expireAfterSeconds": 0 }
     *     )
     *
<<<<<<< HEAD
     * More details on: http://docs.mongodb.org/manual/tutorial/expire-data/
=======
     * More details on: https://docs.mongodb.org/manual/tutorial/expire-data/
>>>>>>> v2-test
     *
     * If you use such an index, you can drop `gc_probability` to 0 since
     * no garbage-collection is required.
     *
<<<<<<< HEAD
     * @param \Mongo|\MongoClient|\MongoDB\Client $mongo   A MongoDB\Client, MongoClient or Mongo instance
     * @param array                               $options An associative array of field options
     *
     * @throws \InvalidArgumentException When MongoClient or Mongo instance not provided
     * @throws \InvalidArgumentException When "database" or "collection" not provided
     */
    public function __construct($mongo, array $options)
    {
        if (!($mongo instanceof \MongoDB\Client || $mongo instanceof \MongoClient || $mongo instanceof \Mongo)) {
            throw new \InvalidArgumentException('MongoClient or Mongo instance required');
        }

        if (!isset($options['database']) || !isset($options['collection'])) {
            throw new \InvalidArgumentException('You must provide the "database" and "collection" option for MongoDBSessionHandler');
=======
     * @throws \InvalidArgumentException When "database" or "collection" not provided
     */
    public function __construct(\MongoDB\Client $mongo, array $options)
    {
        if (!isset($options['database']) || !isset($options['collection'])) {
            throw new \InvalidArgumentException('You must provide the "database" and "collection" option for MongoDBSessionHandler.');
>>>>>>> v2-test
        }

        $this->mongo = $mongo;

<<<<<<< HEAD
        $this->options = array_merge(array(
=======
        $this->options = array_merge([
>>>>>>> v2-test
            'id_field' => '_id',
            'data_field' => 'data',
            'time_field' => 'time',
            'expiry_field' => 'expires_at',
<<<<<<< HEAD
        ), $options);
    }

    /**
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritdoc}
=======
        ], $options);
    }

    /**
     * @return bool
>>>>>>> v2-test
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function destroy($sessionId)
    {
        $methodName = $this->mongo instanceof \MongoDB\Client ? 'deleteOne' : 'remove';

        $this->getCollection()->$methodName(array(
            $this->options['id_field'] => $sessionId,
        ));
=======
    protected function doDestroy(string $sessionId)
    {
        $this->getCollection()->deleteOne([
            $this->options['id_field'] => $sessionId,
        ]);
>>>>>>> v2-test

        return true;
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     */
    public function gc($maxlifetime)
    {
        $methodName = $this->mongo instanceof \MongoDB\Client ? 'deleteOne' : 'remove';

        $this->getCollection()->$methodName(array(
            $this->options['expiry_field'] => array('$lt' => $this->createDateTime()),
        ));
=======
     * @return bool
     */
    public function gc($maxlifetime)
    {
        $this->getCollection()->deleteMany([
            $this->options['expiry_field'] => ['$lt' => new \MongoDB\BSON\UTCDateTime()],
        ]);
>>>>>>> v2-test

        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function write($sessionId, $data)
    {
        $expiry = $this->createDateTime(time() + (int) ini_get('session.gc_maxlifetime'));

        $fields = array(
            $this->options['time_field'] => $this->createDateTime(),
            $this->options['expiry_field'] => $expiry,
        );

        $options = array('upsert' => true);

        if ($this->mongo instanceof \MongoDB\Client) {
            $fields[$this->options['data_field']] = new \MongoDB\BSON\Binary($data, \MongoDB\BSON\Binary::TYPE_OLD_BINARY);
        } else {
            $fields[$this->options['data_field']] = new \MongoBinData($data, \MongoBinData::BYTE_ARRAY);
            $options['multiple'] = false;
        }

        $methodName = $this->mongo instanceof \MongoDB\Client ? 'updateOne' : 'update';

        $this->getCollection()->$methodName(
            array($this->options['id_field'] => $sessionId),
            array('$set' => $fields),
            $options
=======
    protected function doWrite(string $sessionId, string $data)
    {
        $expiry = new \MongoDB\BSON\UTCDateTime((time() + (int) ini_get('session.gc_maxlifetime')) * 1000);

        $fields = [
            $this->options['time_field'] => new \MongoDB\BSON\UTCDateTime(),
            $this->options['expiry_field'] => $expiry,
            $this->options['data_field'] => new \MongoDB\BSON\Binary($data, \MongoDB\BSON\Binary::TYPE_OLD_BINARY),
        ];

        $this->getCollection()->updateOne(
            [$this->options['id_field'] => $sessionId],
            ['$set' => $fields],
            ['upsert' => true]
        );

        return true;
    }

    /**
     * @return bool
     */
    public function updateTimestamp($sessionId, $data)
    {
        $expiry = new \MongoDB\BSON\UTCDateTime((time() + (int) ini_get('session.gc_maxlifetime')) * 1000);

        $this->getCollection()->updateOne(
            [$this->options['id_field'] => $sessionId],
            ['$set' => [
                $this->options['time_field'] => new \MongoDB\BSON\UTCDateTime(),
                $this->options['expiry_field'] => $expiry,
            ]]
>>>>>>> v2-test
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function read($sessionId)
    {
        $dbData = $this->getCollection()->findOne(array(
            $this->options['id_field'] => $sessionId,
            $this->options['expiry_field'] => array('$gte' => $this->createDateTime()),
        ));
=======
    protected function doRead(string $sessionId)
    {
        $dbData = $this->getCollection()->findOne([
            $this->options['id_field'] => $sessionId,
            $this->options['expiry_field'] => ['$gte' => new \MongoDB\BSON\UTCDateTime()],
        ]);
>>>>>>> v2-test

        if (null === $dbData) {
            return '';
        }

<<<<<<< HEAD
        if ($dbData[$this->options['data_field']] instanceof \MongoDB\BSON\Binary) {
            return $dbData[$this->options['data_field']]->getData();
        }

        return $dbData[$this->options['data_field']]->bin;
    }

    /**
     * Return a "MongoCollection" instance.
     *
     * @return \MongoCollection
     */
    private function getCollection()
=======
        return $dbData[$this->options['data_field']]->getData();
    }

    private function getCollection(): \MongoDB\Collection
>>>>>>> v2-test
    {
        if (null === $this->collection) {
            $this->collection = $this->mongo->selectCollection($this->options['database'], $this->options['collection']);
        }

        return $this->collection;
    }

    /**
<<<<<<< HEAD
     * Return a Mongo instance.
     *
     * @return \Mongo|\MongoClient|\MongoDB\Client
=======
     * @return \MongoDB\Client
>>>>>>> v2-test
     */
    protected function getMongo()
    {
        return $this->mongo;
    }
<<<<<<< HEAD

    /**
     * Create a date object using the class appropriate for the current mongo connection.
     *
     * Return an instance of a MongoDate or \MongoDB\BSON\UTCDateTime
     *
     * @param int $seconds An integer representing UTC seconds since Jan 1 1970.  Defaults to now.
     *
     * @return \MongoDate|\MongoDB\BSON\UTCDateTime
     */
    private function createDateTime($seconds = null)
    {
        if (null === $seconds) {
            $seconds = time();
        }

        if ($this->mongo instanceof \MongoDB\Client) {
            return new \MongoDB\BSON\UTCDateTime($seconds * 1000);
        }

        return new \MongoDate($seconds);
    }
=======
>>>>>>> v2-test
}
