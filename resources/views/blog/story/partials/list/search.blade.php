<div class="block">
    <div class="block-header bg-gray-lighter">
        <h3 class="block-title">Search</h3>
    </div>
    <div class="block-content block-content-full">
        <div class="input-group input-group-lg">
            <input class="form-control" type="text" placeholder="Type and hit enter.." v-model="search" 
                   v-on:keyup.enter="getList(pagination.current_page, pagination.per_page, search)">
            <div class="input-group-btn">
                <button class="btn btn-default" v-on:click="getList(pagination.current_page, pagination.per_page, search)">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>