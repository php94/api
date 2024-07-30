{include common/header@php94/admin}
<div class="my-4">
    <div class="h1">接口管理</div>
</div>

<div class="mb-2">
    <p>方式一：url传参数 <code>网址/api/令牌/接口路径</code></p>
    <p>方式二：<code>网址/api/接口路径</code> 同时在请求头加 <code>Authorization: Bearer 令牌</code></p>
</div>

<div>
    <a class="btn btn-primary" href="{echo $router->build('/php94/api/api/create')}">新增接口</a>
</div>

<div class="my-4">
    <form class="row gy-2 gx-3 align-items-center" action="{echo $router->build('/php94/api/api/index')}" method="GET">
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
                <th class="text-nowrap">路径</th>
                <th class="text-nowrap">标题</th>
                <th class="text-nowrap">简介</th>
                <th class="text-nowrap">方法</th>
                <th class="text-nowrap">管理</th>
            </tr>
        </thead>
        <tbody>
            {foreach $datas as $vo}
            <tr>
                <td>{$vo.path}</td>
                <td>{$vo.title}</td>
                <td>{$vo.description}</td>
                <td>
                    {foreach $methods as $method}
                    {if is_null($vo['code_' . $method])}
                    <a href="{echo $router->build('/php94/api/api/code', ['id'=>$vo['id'], 'method'=>$method])}" class="link-secondary">{$method}</a>
                    {else}
                    <a href="{echo $router->build('/php94/api/api/code', ['id'=>$vo['id'], 'method'=>$method])}" class="link-primary">{$method}</a>
                    {/if}
                    {/foreach}
                </td>
                <td>
                    <a href="{echo $router->build('/php94/api/api/update', ['id'=>$vo['id']])}">编辑</a>
                    <a href="{echo $router->build('/php94/api/api/delete', ['id'=>$vo['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
<div class="d-flex align-items-center flex-wrap gap-1 py-3">
    <a class="btn btn-primary {$page>1?'':'disabled'}" href="{echo $router->build('/php94/api/api/index', array_merge($_GET, ['page'=>1]))}">首页</a>
    <a class="btn btn-primary {$page>1?'':'disabled'}" href="{echo $router->build('/php94/api/api/index', array_merge($_GET, ['page'=>max($page-1, 1)]))}">上一页</a>
    <div class="d-flex align-items-center gap-1">
        <input class="form-control" type="number" name="page" min="1" max="{$pages}" value="{$page}" onchange="location.href=this.dataset.url.replace('__PAGE__', this.value)" data-url="{echo $router->build('/php94/api/api/index', array_merge($_GET, ['page'=>'__PAGE__']))}">
        <span>/{$pages}</span>
    </div>
    <a class="btn btn-primary {$page<$pages?'':'disabled'}" href="{echo $router->build('/php94/api/api/index', array_merge($_GET, ['page'=>min($page+1, $pages)]))}">下一页</a>
    <a class="btn btn-primary {$page<$pages?'':'disabled'}" href="{echo $router->build('/php94/api/api/index', array_merge($_GET, ['page'=>$pages]))}">末页</a>
    <div>共{$total}条</div>
</div>
{include common/footer@php94/admin}