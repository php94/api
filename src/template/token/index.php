{include common/header@php94/admin}
<h1 class="py-3">令牌管理</h1>

<div class="d-flex flex-column gap-3">
    <div>
        <a class="btn btn-primary" href="{echo $router->build('/php94/api/token/create')}">创建令牌</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered mb-0 d-table-cell">
            <thead>
                <tr>
                    <th>令牌名称</th>
                    <th>令牌</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach $datas as $vo}
                <tr>
                    <td class="text-nowrap">{$vo.title}</td>
                    <td class="text-nowrap">{$vo.code}</td>
                    <td class="text-nowrap">
                        <a href="{echo $router->build('/php94/api/token/update', ['id'=>$vo['id']])}">编辑</a>
                        <a href="{echo $router->build('/php94/api/token/delete', ['id'=>$vo['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                        <a href="{echo $router->build('/php94/api/access/index', ['token_id'=>$vo['id']])}">权限设置</a>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex align-items-center flex-wrap gap-1 py-3">
    <a class="btn btn-primary {$page>1?'':'disabled'}" href="{echo $router->build('/php94/api/token/index', array_merge($_GET, ['page'=>1]))}">首页</a>
    <a class="btn btn-primary {$page>1?'':'disabled'}" href="{echo $router->build('/php94/api/token/index', array_merge($_GET, ['page'=>max($page-1, 1)]))}">上一页</a>
    <div class="d-flex align-items-center gap-1">
        <input class="form-control" type="number" name="page" min="1" max="{$pages}" value="{$page}" onchange="location.href=this.dataset.url.replace('__PAGE__', this.value)" data-url="{echo $router->build('/php94/api/token/index', array_merge($_GET, ['page'=>'__PAGE__']))}">
        <span>/{$pages}</span>
    </div>
    <a class="btn btn-primary {$page<$pages?'':'disabled'}" href="{echo $router->build('/php94/api/token/index', array_merge($_GET, ['page'=>min($page+1, $pages)]))}">下一页</a>
    <a class="btn btn-primary {$page<$pages?'':'disabled'}" href="{echo $router->build('/php94/api/token/index', array_merge($_GET, ['page'=>$pages]))}">末页</a>
    <div>共{$total}条</div>
</div>
{include common/footer@php94/admin}