
<x-list-tasks :project="$project" />

<script>
  $(function() {
    var initialIdsOrder = [];

    function updateInitialIdsOrder() {
      initialIdsOrder = [];
      $("#tasks-drop li").each(function() {
        if ($(this).attr('item-id')) {
          initialIdsOrder.push($(this).attr('item-id'));
        }
      });
    }

    updateInitialIdsOrder();

    $("#tasks-drop").sortable({
      connectWith: ".connectedSortable",
      opacity: 0.5,
    });

    $(".connectedSortable").on("sortupdate", function(event, ui) {
      var currentIdsOrder = [];
      $("#tasks-drop li").each(function() {
        if ($(this).attr('item-id')) {
          currentIdsOrder.push($(this).attr('item-id'));
        }
      });

      if (JSON.stringify(currentIdsOrder) !== JSON.stringify(initialIdsOrder)) {
        initialIdsOrder = currentIdsOrder.slice();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          url: "{{ url('/project/'.$project->id.'/reorderTasks') }}",
          method: 'POST',
          data: { ids: currentIdsOrder },
          success: function(data) {
            $('#project-info-div').load("{{ url('project/show/' . $project->id) }}");
          }
        });
      }
    });
  });
</script>
