<div role="alert" aria-live="assertive" aria-atomic="true" class="toast <?php echo \Core\Session::get('toast')['className'];?>" 
    data-autohide="false" style="position: fixed; top: 15px; right: 15px;">
    <div class="toast-header">
        <strong class="mr-auto">Pargraf lex</strong>
        
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        <?php echo \Core\Session::get('toast')['message'];?>
    </div>
</div>
<?php \Core\Session::clear('toast'); ?>