@extends('layouts.main')

@section('content')

<section class="static about-sec">
    <div class="container">

        <?php echo htmlspecialchars_decode(stripslashes($setting->description));  ?>


    </div>
</section>
@endsection