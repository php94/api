{include common/header@php94/admin}
<div class="my-4">
    <div class="h1">日志管理</div>
</div>

<div class="my-4">
    <form class="row gy-2 gx-3 align-items-center" action="{echo $router->build('/php94/api/log/index')}" method="GET">
        <input type="hidden" name="page" value="1">
        <div class="col-auto">
            <label class="visually-hidden">搜索</label>
            <input type="search" class="form-control" name="q" value="{:$request->get('q')}" onchange="this.form.submit();">
        </div>
    </form>
</div>
<div class="table-responsive my-4">
    <table class="table table-bordered table-striped d-table-cell">
        <thead>
            <tr>
                <th class="text-nowrap">ID</th>
                <th class="text-nowrap">令牌</th>
                <th class="text-nowrap">接口</th>
                <th class="text-nowrap">错误</th>
                <th class="text-nowrap">消息</th>
                <th class="text-nowrap">日期</th>
            </tr>
        </thead>
        <tbody>
            {foreach $datas as $vo}
            <tr>
                <td>{$vo.id}</td>
                <td>{$vo.code}</td>
                <td>{$vo.path}</td>
                <td>{$vo.error}</td>
                <td>{$vo.message}</td>
                <td>{$vo.datetime}</td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
<div class="d-flex align-items-center flex-wrap gap-1 py-3">
    <a class="btn btn-primary {$page>1?'':'disabled'}" href="{echo $router->build('/php94/api/log/index', array_merge($_GET, ['page'=>1]))}">首页</a>
    <a class="btn btn-primary {$page>1?'':'disabled'}" href="{echo $router->build('/php94/api/log/index', array_merge($_GET, ['page'=>max($page-1, 1)]))}">上一页</a>
    <div class="d-flex align-items-center gap-1">
        <input class="form-control" type="number" name="page" min="1" max="{$pages}" value="{$page}" onchange="location.href=this.dataset.url.replace('__PAGE__', this.value)" data-url="{echo $router->build('/php94/api/log/index', array_merge($_GET, ['page'=>'__PAGE__']))}">
        <span>/{$pages}</span>
    </div>
    <a class="btn btn-primary {$page<$pages?'':'disabled'}" href="{echo $router->build('/php94/api/log/index', array_merge($_GET, ['page'=>min($page+1, $pages)]))}">下一页</a>
    <a class="btn btn-primary {$page<$pages?'':'disabled'}" href="{echo $router->build('/php94/api/log/index', array_merge($_GET, ['page'=>$pages]))}">末页</a>
    <div>共{$total}条</div>
</div>
{include common/footer@php94/admin}