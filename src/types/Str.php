<?php

namespace Sofi\data\types;

/**
 * Description of String
 *
 * @author hawk
 */
class Str
{

    protected $storage;

    public function __construct($string)
    {
        $this->storage = (string) $string;
    }
    
    

    public function склонения()
    {
        return new class($this->storage) {

            const согласные = ['б', 'в', 'г', 'д', 'ж', 'з', 'к', 'л', 'м', 'н', 'с', 'ф', 'х', 'ц', 'ч', 'ш', 'щ'];

            protected $storage;

            public function __construct($string)
            {
                $this->storage = (string) $string;
            }

            function куда()
            {
                if (mb_strpos($this->storage, ' ') > 0) {
                    return $this->storage;
                }
                if (mb_strpos($this->storage, '-') > 0) {
                    return $this->storage;
                }
                $len = mb_strlen($this->storage);
                $end = mb_substr($this->storage, $len - 2);
                switch ($end) {
                    case 'ия':
                        $nend = 'ию';
                        break;
                    case 'уа':
                        $nend = 'уа';
                        break;

                    default :
                        $end1 = mb_substr($this->storage, $len - 1);
                        if (in_array($end1, self::согласные)) {
                            return $this->storage;
                        } else {
                            switch ($end1) {
                                case 'а':
                                    $nend = 'у';
                                    break;

                                default:
                                    return $this->storage;
                            }
                            return mb_substr($this->storage, 0, $len - 1) . $nend;
                        }
                        break;
                }

                return mb_substr($this->storage, 0, $len - 2) . $nend;
            }

            function где()
            {
                if (mb_strpos($this->storage, ' ') > 0) {
                    return $this->storage;
                }
                if (mb_strpos($this->storage, '-') > 0) {
                    return $this->storage;
                }
                $len = mb_strlen($this->storage);
                $end = mb_substr($this->storage, $len - 2);
                switch ($end) {
                    case 'ия':
                        $nend = 'ии';
                        break;
                    case 'уа':
                        $nend = 'уа';
                        break;
                    case 'ль':
                        $nend = 'ле';
                        break;

                    default :
                        $end1 = mb_substr($this->storage, $len - 1);
                        if (in_array($end1, self::согласные)) {
                            return $this->storage.'е';
                        } else {
                            switch ($end1) {
                                case 'а':
                                    $nend = 'е';
                                    break;

                                default:
                                    return $this->storage;
                            }
                            return mb_substr($this->storage, 0, $len - 1) . $nend;
                        }
                        break;
                }

                return mb_substr($this->storage, 0, $len - 2) . $nend;
            }
            
            function чего()
            {
                if (mb_strpos($this->storage, ' ') > 0) {
                    return $this->storage;
                }
                if (mb_strpos($this->storage, '-') > 0) {
                    return $this->storage;
                }
                $len = mb_strlen($this->storage);
                $end = mb_substr($this->storage, $len - 2);
                switch ($end) {
                    case 'ия':
                        $nend = 'ии';
                        break;
                    
                    case 'уа':
                        $nend = 'уа';
                        break;
                    
                    case 'ль':
                        $nend = 'ля';
                        break;

                    default :
                        $end1 = mb_substr($this->storage, $len - 1);
                        if (in_array($end1, self::согласные)) {
                            return $this->storage.'а';
                        } else {
                            switch ($end1) {
                                case 'а':
                                    $nend = 'ы';
                                    break;

                                default:
                                    return $this->storage;
                            }
                            return mb_substr($this->storage, 0, $len - 1) . $nend;
                        }
                        break;
                }

                return mb_substr($this->storage, 0, $len - 2) . $nend;
            }
        };
    }

}
