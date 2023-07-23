<div v-if="toastSuccess" class="toast-container" style="right: 10px; position: fixed; top: calc(20% + 50px);">
    <div id="toast" class="toast fade show">
        <div class="toast-header">
            <strong class="me-auto"><i class="fa fa-commenting" aria-hidden="true"></i> Сообщение</strong>
            <small>только что</small>
            <button @click="toastSuccess=false" type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>

        <div v-html="toastHtml" class="toast-body">

        </div>
    </div>
</div>
