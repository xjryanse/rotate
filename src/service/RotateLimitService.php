<?php
namespace xjryanse\rotate\service;

/**
 * 
 */
class RotateLimitService
{
    use \xjryanse\traits\InstTrait;
    use \xjryanse\traits\MainModelTrait;
    use \xjryanse\traits\MainModelQueryTrait;

    protected static $mainModel;
    protected static $mainModelClass    = '\\xjryanse\\rotate\\model\\RotateLimit';

}
