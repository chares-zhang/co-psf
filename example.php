class User extends \Db\Model{
    public $_module = "material";
}

function test1(){
    $user = new User();
    $resp = yield from $user->query("select * from statistic_device limit 1");
    return $resp;
}

function test(){
    $user = new User();
    //Coroutine::wrap(test1());
    try{
        $resp = yield from $user->query("select * from statistic_device limit 1");
        $multi = new \Coroutine\Multi();
        $multi->wrap(test1());
        $resp = yield $multi;
        var_dump($resp);
        $resp = yield from \Http\Client::get("yuyang-hyaf.huanleguang.cn","/home/poster?zid=2881064");
        var_dump($resp);
    }catch(Exception $e){
        var_dump($e);
    }
}

\Coroutine::init();
\Coroutine::wrap(test());
\Coroutine::wait();
