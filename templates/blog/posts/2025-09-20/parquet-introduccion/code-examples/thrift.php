<?php

use Flow\Parquet\Thrift\FileMetaData;
use Thrift\Protocol\TCompactProtocol;
use Thrift\Transport\TMemoryBuffer;

$metadataLength = \unpack($this->byteOrder->value, $this->stream->read(4, $fileTotalSize - 8))[1];

$fileMetadata = new FileMetaData();
$fileMetadata->read(
    new TCompactProtocol(
        new TMemoryBuffer(
            $this->stream->read($metadataLength, $fileTotalSize - ($metadataLength + 8))
        )
    )
);