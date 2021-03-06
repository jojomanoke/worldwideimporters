<?php


namespace Classes\Product;

use Classes\Query\Query;

/**
 * Autocomplete for editors
 *
 * Class Product
 * @package Classes\Product\Product
 * @property int StockItemID
 * @property string StockItemName
 * @property int SupplierID
 * @property int ColorID
 * @property int UnitPackageID
 * @property int OuterPackageID
 * @property string Brand
 * @property string Size
 * @property int LeadTimeDays
 * @property int QuantityPerOuter
 * @property int IsChillerStock
 * @property string Barcode
 * @property float TaxRate
 * @property float UnitPrice
 * @property float RecommendedRetailPrice
 * @property float TypicalWeightPerUnit
 * @property string MarketingComments
 * @property string InternalComments
 * @property string CustomFields
 * @property string Tags
 * @property string SearchDetails
 * @property int LastEditedBy
 * @property string ValidFrom
 * @property string ValidTo
 */
class Product extends Query
{
    public function __construct(string $className = 'Classes\Product\Product')
    {
        parent::__construct($className);
    }
    
    public static function find(int $id) {
        $className = (new self())->className;
        $query = "SELECT * FROM stockitems WHERE StockItemID = $id";
        return self::convertToClassObject($className, self::getResults($query, $className));
    }
    
    /**
     * Creates a collection from all data that has been fetched from the database
     *
     * @param string $columns
     * @return \Classes\Product\Product
     * @author sylvano verkuyl<sylvanoverkuyl@hotmail.com>
     */
    public static function all($columns = '*'): Product
    {
        $query = "SELECT $columns FROM stockitems";
        $className = (new self())->className;
        return self::convertToClassObject($className, self::getResults($query, $className));
    }
    
    /**
     * recast stdClass object to an object of a type
     *
     * @param mixed $object
     * @return mixed new, typed object
     * @throws \InvalidArgumentException
     */
    protected static function convertToProductObject($object)
    {
        $newCollection = new self();
        foreach($object as $property => &$value) {
            $newCollection->$property = &$value;
            unset($object->$property);
        }
        unset($value);
        return $newCollection;
    }
    
    /**
     * @param $array
     * @return mixed
     */
    protected static function convertArrayToProductObject($array)
    {
        return self::convertToProductObject((object)$array);
    }
}