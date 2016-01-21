<?php
/**
 * Class Myredis
 *
 * phpredis
 *
 * https://github.com/phpredis/phpredis
 */
class Myredis{
    private $commands = [
        /* ch0 */
        'redis-cli SHUTDOWN',
        'redis-cli PING',
        'redis config: /usr/local/etc/redis.conf ',
        'redis-server /path/to/redis.conf',
        'redis-server redis.conf --loglevel warning',
        '> CONFIG SET loglevel warning',
        '> CONFIG GET loglevel',
        '> SELECT 1', // default 16 DB, like `namespace`
        '> DBSIZE', // get the number of stored keys
        /* ch1 string */
        '> SET key val', // '> KEYS pattern',
        '> GET key',
        '> KEYS *', // bad efficiency
        '> EXISTS key',
        '> DEL key [ key key...]', // not support pattern
        '> TYPE key',
        '> INCR key', // return added value
        '> INCRBY key increment', // incr special number
        '> DECR key',
        '> DECRBY key decrement',
        '> INCRBYFLOAT key incrementFloat',
        '> APPEND key value', // return string length
        '> STRLEN key',
        '> MGET | MSET', // multi operation
        'BIT OP',
        /* ch2 hash */
        '> HSET key field value',
        '> HGET key field',
        '> HGETALL key',
        '> HMSET | HMGET', // multi-operation
        '> HEXISTS key field',
        '> HSETNX key field value', // assign if not exist this field
        '> HINCRBY key field increment',
        '> HDEL key field',
        '> HKEYS key', // get all key fields
        '> HVALS key', // get all key values
        '> HLEN key', // get key count
        /* ch3 list: ordered list, queue, flow, etc */
        '> LPUSH key value [ value value ...]',
        '> RPUSH key value []',
        '> LPOP key',
        '> RPOP key',
        '> LLEN key',
        '> LRANGE key start stop', // get flip [start, stop]
        '> LREM key count value',
        '> LINDEX key index', // get value
        '> LSET key index value',
        '> LTRIM key start end', // trim and get list [start, end]
        '> LINSERT key BEFORE|AFTER pivot value',
        '> RPOPLPUSH source destination',
        /* ch4 set: tag*/
        '> SADD key member',
        '> SREM key member',
        '> SMEMBERS key',
        '> SISMEMBER key member',
        '> SDIFF key [key key ...]',
        '> SINTER key []',
        '> SUNION key []',
        '> SCARD key', // count member of set
        '', // set calculate & store
        '> SPOP key',
        /* ch5 order set */
        '> ZADD key score member',
        '> ZSCORE key member',
        '> ZRANGE | ZREVERANGE key start stop',
        '> ZRANGEBYSCORE key min max',
        '> ZINCRBY key increment member',
        '> ZCARD key', // get count
        '> ZCOUNT key min max', // get count by score
        '> ZREM key member',
        '> ZREMRANGEBYRANK key start stop',
        '> ZREMRANGEBYSCORE key min max',
        '> ZRANK key member',
        '> ', // calculate intersection
        /* new ch1 transaction */
        '> MULTI',
        '> EXEC',

        '> WATCH key', // listening one or more key, if the key is modified, then cancel this transaction
        '> UNWATCH', // cancel listening

        /* expire of key */
        '> EXPIRE key expireTime', // set key expire time
        '> TTL key', // look up the left expire time; out of expire of not set is: -1
        '> PERSIST key',
        // SET | GETSET 命令均会影响key的expire时间,其他操作key的操作不会影响
        '> PEXPIRE key 1000', // == > EXPIRE key 1
        // 如果使用watch监控了一个拥有生存时间的key,该key到期自动删除,并不会被watch认为该健被改变了
        // 通过EXPIRE设置缓存
        // maxmemory-policy: LRU algorithm
        // 有序集合的使用场景: 大数据排序
        '> SORT key', // key: list, set, order set
        '> SORT key BY attr ASC | DESC',
        '> SORT key BY attr1 GET attr2, GET attr3, GET #', // 排序且返回attr2
        '> SORT key GET x STORE key2', // 将排序后get的值存到key2里
        // SORT 是有很多地方都需要优化的
        /* ch2 消息通知 */
        /**
         * producer & consumer
         */
        /**
         * Publish & Subscribe model
         */
        '> PUBLISH channel value', // regexp
        '> SUBSCRIBE channel',
        /**
         * pipeline
         */
        /**
         * script: Lua
         *
         * cjson & cmsgpack
         *
         *
         */
        /**
         * Redis 快照:
         * > SAVE | BGSAVE
         *
         * Redis RDB
         *
         * 定时备份RDB文件来进行redis的备份
         *
         * AOF持久化
         */
        /**
         * Replication
         *
         * $ redis-server --port 6380 --slaveof 127.0.0.1 6379
         * $ redis-cli -p 6380
         *
         */
        /**
         * Security
         *
         * > bind 127.0.0.1
         *
         * > requirepass password
         * > AUTH password
         *
         * > telnet IP PORT
         *
         * > SLOWLOG GET
         *
         * > MONITOR
         */
    ];

    public $redis;

    public function __construct($host = '127.0.0.1', $port = '6379', $timeout = 2.5){
        $this->redis = new Redis() or die('wrong');
        $this->redis->connect($host, $port, $timeout);
    }

    public function pageView(){
        $key = 'POST:articleID:page.view';
        $keyNameMethod = 'ObjType:ObjID:ObjAttr'; // multi word: 'ObjAttr1.Attr2'

//        $postID = INCR posts:count;
//        $serializedPost = serialize($title, $ctn, $author, $time);
//        SET post:$postID:data $serializedPost
    }

    private function limitView(){
        /**
         * 对每一个IP的访问次数进行限制: keyIP + Number + Expire
         * rate.limiting.IP = number
         * EXPIRE rate.limiting.IP 60
         */
    }

    public function hastDemo(){
//        $postID = INCR posts:count
//        HMSET post:$postID, title, $title, content, $content

    }

    public function random(){
        $key = $this->redis->randomKey();
        return $key;
        return $this->redis->get($key);
    }
}
$redis = new Myredis();

