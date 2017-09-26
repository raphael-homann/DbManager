<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 26/09/17
 * Time: 11:24
 */

namespace Efrogg\Db\Adapters;


trait DbAdapterAwareTrait
{
    /**
     * @var DbAdapter
     */
    protected $db;

    /**
     * @param DbAdapter $db
     * @return $this
     */
    public function setDb(DbAdapter $db): self
    {
        $this->db = $db;

        return $this;
    }

    /**
     * @return DbAdapter
     */
    public function getDb(): DbAdapter
    {
        return $this->db;
    }

}