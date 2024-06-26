
<x-list-tasks :project="$project" />

<script>
  $(function() {
    var initialIdsOrder = [];

    // Store initial order of task IDs
    function updateInitialIdsOrder() {
      initialIdsOrder = [];
      $("#tasks-drop li").each(function() {
        if ($(this).attr('item-id')) {
          initialIdsOrder.push($(this).attr('item-id'));
        }
      });
    }

    // Update initial order on page load
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

      // Check if the order has changed
      if (JSON.stringify(currentIdsOrder) !== JSON.stringify(initialIdsOrder)) {
        // Update initial order to the new order
        initialIdsOrder = currentIdsOrder.slice();

        // Setup CSRF token for AJAX
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        // Send AJAX request
        $.ajax({
          url: "{{ url('/project/'.$project->id.'/reorderTasks') }}",
          method: 'POST',
          data: { ids: currentIdsOrder },
          success: function(data) {
            // Update the project info div
            $('#project-info-div').load("{{ url('project/show/' . $project->id) }}");
          }
        });
      }
    });
  });
</script>
