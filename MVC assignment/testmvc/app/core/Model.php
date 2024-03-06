<?php

/**
 * Main Model trait
 */
trait Model
{
    use Database;

    protected $limit        = 10;
    protected $offset       = 0;
    protected $order_type   = "desc";
    protected $order_column = "id";
    public $errors          = [];

    public function findAll()
    {
        $query = "SELECT * FROM $this->table ORDER BY $this->order_column $this->order_type LIMIT :limit OFFSET :offset";
        $params = [':limit' => $this->limit, ':offset' => $this->offset];

        return $this->query($query, $params);
    }

    public function where($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";

        foreach ($keys as $key) {
            $query .= "$key = :$key AND ";
        }

        foreach ($keys_not as $key) {
            $query .= "$key != :$key AND ";
        }

        $query = rtrim($query, " AND ");

        $query .= " ORDER BY $this->order_column $this->order_type LIMIT :limit OFFSET :offset";
        $params = array_merge($data, $data_not, [':limit' => $this->limit, ':offset' => $this->offset]);

        return $this->query($query, $params);
    }

    // ... (similar updates for other methods)

    public function insert($data)
    {
        /** remove unwanted data **/
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);

        $query = "INSERT INTO $this->table (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";
        $this->query($query, $data);

        // Consider returning true or an indication of success
    }

    // ... (similar updates for other methods)
}
