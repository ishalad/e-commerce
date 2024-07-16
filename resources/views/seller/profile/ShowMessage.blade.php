@extends('seller.layouts.app')

@section('panel_content')
    <?php $admin_data = get_admin(); ?>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Show Message') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <label>{{ translate('Meassage') }}</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group mb-3">
                        <label>{{ $message->message }}</label>
                    </div>
                </div>
            </div>
        </div>
        @if($message->is_replay == 0)
            <div class="card-footer">
                <button type="button" class="btn btn-primary" onclick="OpenPopup()">{{ translate('Send Replay') }}</button>
            </div>
        @endif
    </div>
@endsection

@section('modal')
<!-- Seller Message Modal -->
<div class="modal fade" id="message_modal">
    <div class="modal-dialog">
        <div class="modal-content" id="message-modal-content">
            <form action="{{ route('seller.profile.submit_message') }}" method="POST">
                @csrf
                <input type="hidden" name="sender_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="receiver_id" value="{{ $admin_data->id }}">
                <input type="hidden" name="parent_id" value="{{ $message->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Send Message')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                        <div class="col-sm-9">
                            <label class="col-from-label" for="name"><?= $admin_data->name ?></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Message')}}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" placeholder="Message here..." name="message" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('Send Message')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        function OpenPopup(){
            $('#message_modal').modal('show', {backdrop: 'static'});
        }
    </script>
@endsection 