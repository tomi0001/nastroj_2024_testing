@extends('Doctor.Layout.Main')

@section('content')



@section ('title')
 Strona Główna
@endsection

<br>
    @include('Doctor.Main.calendar')<br>



    @include('Doctor.Main.showAll')

    @include ('Doctor.Main.showMenu')
    @include('Doctor.Main.showMood')
    @include('Doctor.Main.showDrugs')
    @include('Doctor.Main.showAction')
    @if (($sumAll->sum_mood) != "" or (count($listMood)) > 0 )
              <script>
                window.onload=SwitchMenuMoodShow('mood',false);


            </script>

    @elseif (count($listDrugs) > 0)
            <script>
                window.onload=SwitchMenuMoodShow('drugs',false);


            </script>
    @elseif (count($actionPlan) > 0 or count($actionForDay) > 0)
            <script>
                window.onload=SwitchMenuMoodShow('action',false);


            </script>
    @endif
    <br><br><br>









        
          <br><br><br><br>

          <script>
              window.onload=loadSesson();
          </script>


@endsection
