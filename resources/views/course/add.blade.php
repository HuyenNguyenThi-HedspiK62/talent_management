    @extends('layouts.dashboard')
    
    @section('content-header')
        コース追加
    @endsection
@section('content')
<style>
    .multipleChosen, .multipleSelect2{
  width: 300px;
}
</style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 offset-1">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">コース名</label>
                            <div class="col-sm-10">
                            <input value="{{old('schedulename')}}" type="text" name="coursename" class="form-control" placeholder="コース名を入力して下さい" class="@error('schedulename') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">コース詳細</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="info" id="exampleFormControlTextarea1" rows="3">{{old('info')}}</textarea>
                                </div> 
                      </div>
                        <div class="form-group row">
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">開始日</label>
                                <div class="col-sm-6">
                                <input value="{{old('date')}}" type="date" name="date" class="form-control" id="exampleFormControlInput1" class="@error('date') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">終了日</label>
                                <div class="col-sm-6">
                                <input value="{{old('date')}}" type="date" name="date" class="form-control" id="exampleFormControlInput1" class="@error('date') is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="col-sm-4 col-form-label text-right">場所</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="bg-white form-control text-center">
                                    </div>
                                </div>
                                <div class="col-md-6 row">
                                    <label class="col-sm-4 col-form-label text-right">時間</label>
                                    <div class="col-sm-6">
                                        <input  type="text" class="bg-white form-control text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">担当者</label>
                            <div class="col-sm-10">
                            <select name="person" class="form-control select2" style="width: 100%;">
                                <option selected disabled hidden></option>
                                @foreach($persons as $person)
                                    <option @if(old('person') == $person->id) selected @endif value="{{$person->id}}">{{$person->name}}</option>
                                @endforeach
                            </select>
                            @error('person')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">成績満点</label>
                            <div class="col-sm-2">
                            <input type="number" id="quantity" class="bg-white form-control text-center" name="quantity" min="0" max="100">
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="col-sm-3.5 col-form-label text-right">タレント追加(３名選んだ)</label>
                            <div class="col-sm-12">
                            <select name="person" class="form-control select2" style="width: 100%;" >
                                <option selected disabled hidden></option>
                                @foreach($persons as $person)
                                    <option @if(old('person') == $person->id) selected @endif value="{{$person->id}}">{{$person->name}}</option>
                                @endforeach
                            </select>	
                            </div>
                        </div>

                       
                    <div class="form-group d-flex justify-content-end">
                        <a href="{{route('schedule.index', ['option' => 'all'])}}" class="btn btn-danger" style="margin-right: 30px;">一時保存</a>
                        <button type="submit" class="btn btn-success">登録</button>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('script')
<script>
    function deleteSchedule(scheduleId) {
        if (confirm('このスケジュールを削除してもよろしいですか？')) {
            window.location.href = 'http://' + window.location.host + '/schedule/delete/' + scheduleId;
        }
    }
    $(document).ready(function(){
  //Chosen
  $(".multipleChosen").chosen({
      placeholder_text_multiple: "What's your rating" //placeholder
	});
  //Select2
  $(".multipleSelect2").select2({
		placeholder: "What's your rating" //placeholder
	});
})
});
</script>
