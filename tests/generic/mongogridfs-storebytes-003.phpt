--TEST--
MongoGridFS::storeBytes() with arbitrary values
--SKIPIF--
<?php require dirname(__FILE__) . "/skipif.inc";?>
--FILE--
<?php
require_once dirname(__FILE__) . "/../utils.inc";
$mongo = mongo();
$db = $mongo->selectDB(dbname());

$bytes = chr(0) . '4g7' . chr(255) . chr(127) . chr(128) . chr(0);

$gridfs = $db->getGridFS();
$gridfs->drop();
$gridfs->storeBytes($bytes, array('myopt' => new MongoBinData($bytes, MongoBinData::BYTE_ARRAY)));

$file = $gridfs->findOne();

var_dump($bytes === $file->getBytes());
var_dump($bytes === $file->file['myopt']->bin);
--EXPECT--
bool(true)
bool(true)
