@extends('admin.layouts.main')
@section('title', 'Pagination')
@section('content')
<form role="form" method="POST" action="{{ route('admin.settings.store') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-offset-2 col-md-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Home Page</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>Latest Items</label>
                        <input type="number" name="pagination_dashboard_items" class="form-control" value="{{ Setting::get('pagination.dashboard.items') }}">
                    </div>
                    <div class="form-group">
                        <label>Popular Items</label>
                        <input type="number" name="pagination_dashboard_popular" class="form-control" value="{{ Setting::get('pagination.dashboard.popular') }}">
                    </div>
                    <div class="form-group">
                        <label>Featured Items</label>
                        <input type="number" name="pagination_dashboard_featured" class="form-control" value="{{ Setting::get('pagination.dashboard.featured') }}">
                    </div>
                    <div class="form-group">
                        <label>Blog Stories</label>
                        <input type="number" name="pagination_dashboard_stories" class="form-control" value="{{ Setting::get('pagination.dashboard.stories') }}">
                    </div>
                    <div class="form-group">
                        <label>Sellers</label>
                        <input type="number" name="pagination_dashboard_sellers" class="form-control" value="{{ Setting::get('pagination.dashboard.sellers') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Internal Pages</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label>Top collections</label>
                        <input type="number" name="pagination_collections" class="form-control" value="{{ Setting::get('pagination.collections') }}">
                    </div>
                    <div class="form-group">
                        <label>Items on Collection</label>
                        <input type="number" name="pagination_items_collection" class="form-control" value="{{ Setting::get('pagination.items.collection') }}">
                    </div>
                    <div class="form-group">
                        <label>Items on User</label>
                        <input type="number" name="pagination_items_user" class="form-control" value="{{ Setting::get('pagination.items.user') }}">
                    </div>
                    <div class="form-group">
                        <label>Collections on User</label>
                        <input type="number" name="pagination_user_collections" class="form-control" value="{{ Setting::get('pagination.user.collections') }}">
                    </div>
                    <div class="form-group">
                        <label>Followers on User</label>
                        <input type="number" name="pagination_user_followers" class="form-control" value="{{ Setting::get('pagination.user.followers') }}">
                    </div>
                    <div class="form-group">
                        <label>Following on User</label>
                        <input type="number" name="pagination_user_following" class="form-control" value="{{ Setting::get('pagination.user.following') }}">
                    </div>
                    <div class="form-group">
                        <label>Follower Feed</label>
                        <input type="number" name="pagination_user_feed" class="form-control" value="{{ Setting::get('pagination.user.feed') }}">
                    </div>
                    <div class="form-group">
                        <label>Top Sellers</label>
                        <input type="number" name="pagination_user_topsellers" class="form-control" value="{{ Setting::get('pagination.user.topsellers') }}">
                    </div>
                    <div class="form-group">
                        <label>Featured Items</label>
                        <input type="number" name="pagination_user_featured" class="form-control" value="{{ Setting::get('pagination.user.featured') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-primary btn-block">
                    Save
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
