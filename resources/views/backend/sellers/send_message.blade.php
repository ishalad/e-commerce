<form action="{{ route('sellers.submit_message') }}" method="POST">
    @csrf
    <input type="hidden" name="sender_id" value="{{ Auth::user()->id }}">
    <input type="hidden" name="receiver_id" value="{{ $shop->user->id }}">
    <input type="hidden" name="parent_id" value="0">
    
    <div class="modal-header">
        <h5 class="modal-title h6">{{translate('Send Message')}}</h5>
        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
            <div class="col-sm-9">
                <label class="col-from-label" for="name"><?= $shop->user->name ?></label>
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