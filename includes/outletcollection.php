<?php
require_once 'config/config.php';
require_once 'includes/outlet.php';

class OutletCollection implements \Iterator, \Countable
{
    protected $type;

    protected $total = 0;
    protected $position = 0;

    protected $raw = array();
    protected $objects = array();

    public static function getAll() {
	$config = Config::getInstance();
    	return new self(array_keys($config->getOutlet()), 'Outlet');
    }

    public static function getById($id) {
	return new Outlet((int)$id);
    }

    public static function getByIds(array $ids) {
    	return new self($ids, 'Outlet');	
    }

    // constructor requires at least a type
    public function __construct(array $raw = null, $type = null) {
        // a type must be supplied
        if (is_null($type)) {
            throw new \InvalidArgumentException("No Class Type Specified");
        }

        // if a raw array is supplied, we have enough information to build objects
        if (!is_null($raw)) {
            $this->raw = $raw;
            $this->total = count($raw);

            $this->type = $type;
        }

        // anything else is just an empty container
    }

    /**
     * \Iterator Implementation
     */
    public function rewind() {
        $this->position = 0;
    }

    public function next() {
        ++$this->position;
    }

    public function current() {
        return $this->getRow($this->position);
    }

    public function valid() {
        return (!is_null($this->getRow($this->position))) ? true : false;
    }

    public function key() {
        return $this->position;
    }

    /**
     * \Countable Implementation
     */
    public function count() {
        return $this->total;
    }

    private function getRow($position) {
        // invalid row check
        if ($position >= $this->total || $position < 0) {
            return null;
        }

        // return an instantiated object first
        if (isset($this->objects[$position])) {
            return $this->objects[$position];
        }

        if (isset($this->raw[$position])) {
            $obj = new $this->type($this->raw[$position]);
            $this->objects[$position] = $obj;

            return $obj;
        }

        throw new \InvalidArgumentException("No Data or Object Found at Row {$position}");
    }

    public function add($entry) {
        if (!$entry instanceof $this->type) {
            throw new \InvalidArgumentException("Invalid Class Type - " . get_class($entry) . " - This Object Supports - " . $this->type);
        }

        // append the object to the end of the objects array, leaving enough room if this collection was called with raw data
        $this->objects[$this->total] = $entry;
        $this->total++;

        return $this;
    }
}
