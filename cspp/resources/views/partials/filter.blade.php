<div class="btn-group float-left" role="group">
  <button id="btnGroupAssigned" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter by
  </button>

  <ul class="dropdown-menu" aria-labelledby="btnGroupAssigned">
    <li><a href="javascript:;" class="dropdown-item filterContactedDate">Range date</a></li>
    <!-- <li class="dropdown-divider"></li>
    <li><a href="javascript:;" class="dropdown-item notAssigned">Not yet assigned</a></li>
    <li><a href="javascript:;" class="dropdown-item doneAssigned">Already assigned</a></li> -->
    <li class="dropdown-divider"></li>

    <li class="dropdown-submenu">
      <a href="javascript:;" class="subMenuCatWeb dropdown-item dropdown-toggle" data-toggle="dropdown">Category web</a>
      <ul class="dropdown-menu" id='catWebUl'>
        <!-- luffy 14 Dec 2019 12:31 pm -->
        <!-- dynamic data when upload for category web. -->
        @if($catWeb)
          @foreach($catWeb as $singWeb)
            <li><a href="javascript:;" class="dropdown-item catWeb{{ $singWeb->id }}">{{ $singWeb->name }}</a></li>
          @endforeach
        @endIf
      </ul>
    </li>
    <li class="dropdown-divider"></li>
    <li class="dropdown-submenu">
      <a href="javascript:;" class="subMenuCatGame dropdown-item dropdown-toggle" data-toggle="dropdown">Category game</a>
      <ul class="dropdown-menu" id='catGameUl'>
        <!-- luffy 14 Dec 2019 12:37 pm -->
        <!-- dynamic data when upload for category game. -->
        @if($catGames)
          @foreach($catGames as $singGame)
            <li><a href="javascript:;" class="dropdown-item catGame{{ $singGame->id }}">{{ $singGame->name }}</a></li>
          @endforeach
        @endIf
      </ul>
    </li>
    <!-- <li class="dropdown-divider"></li>
    <li><a href="javascript:;" class="dropdown-item byError">Error</a></li> -->
    <li class="dropdown-divider"></li>
    <li><a href="javascript:;" class="dropdown-item clearFilter">Clear filter</a></li>
  </ul>
</div>