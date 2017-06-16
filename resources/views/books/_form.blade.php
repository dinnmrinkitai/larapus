<div class="form-group{{ $errors->has('title') ? 'has-error' : '' }}">
	{!! Form::label('title', 'Judul', ['class'=>'col-md-2 control-label']) !!}
		<div class="col-md-4">
			{!! Form::text('title', null, ['class'=>'form-control']) !!}
			{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ $errors->has('author_id') ? 'has-error' : '' }}">
	{!! Form::label('author_id', 'Penulis', ['class'=>'col-md-2 control-label']) !!}
		<div class="col-md-4">
			{!! Form::text('author_id', null, ['class'=>'form-control']) !!}
			{!! $errors->first('author_id', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ $errors->has('amount') ? 'has-error' : '' }}">
	{!! Form::label('amount', 'Jumlah', ['class'=>'col-md-2 control-label']) !!}
		<div class="col-md-4">
			{!! Form::text('amount', null, ['class'=>'form-control']) !!}
			{!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ $errors->has('cover') ? 'has-error' : '' }}">
	{!! Form::label('cover', 'Jumlah', ['class'=>'col-md-2 control-label']) !!}
		<div class="col-md-4">
			{!! Form::text('cover', null, ['class'=>'form-control']) !!}
			{!! $errors->first('cover', '<p class="help-block">:message</p>') !!}
		</div>
	</div>


	<div class="form-group">
		<div class="col-md-4 col-md-offset-2">
			{!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!}
		</div>
	</div>