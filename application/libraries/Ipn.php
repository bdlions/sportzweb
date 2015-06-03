<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ipn {
    protected $status;
    protected $productName;
    protected $productId;
    protected $rawData;

    public function __construct($ipn)
    {
        $this->rawData = $ipn;

        if (is_array($ipn)) {
            if ( ! empty($ipn['status'])) {
                $this->status = $ipn['status'];
            }
            if ( ! empty($ipn['memo'])) {
                $memo = json_decode($ipn['memo'], true);
                if (is_array($memo)) {
                    if (isset($memo['product_name'])) {
                        $this->productName = $memo['product_name'];
                    }
                    if (isset($memo['product_id'])) {
                        $this->productId = $memo['product_id'];
                    }
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getRawData()
    {
        return $this->rawData;
    }
}
