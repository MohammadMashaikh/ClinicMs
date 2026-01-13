<script>
    function confirmation(ev)
    {
        ev.preventDefault();

        var UrlToRedirect = ev.currentTarget.getAttribute('href');

        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                ev.target.closest('form').submit();
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    }
</script>


<script>
    function confirmationHref(ev) {
        ev.preventDefault();

        var UrlToRedirect = ev.currentTarget.getAttribute('href');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                window.location.href = UrlToRedirect;

                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    }
</script>

<script>
    function prevent(text1, text2) {
        Swal.fire({
            icon: "error",
            title: text1,
            text: text2,
        });
    }
</script>




<script>
    function confirmAppointment(ev)
    {
        ev.preventDefault();

        var UrlToRedirect = ev.currentTarget.getAttribute('href');

        Swal.fire({
        title: "Are you sure you?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Confirm it!"
        }).then((result) => {
            if (result.isConfirmed) {

                ev.target.closest('form').submit();
                Swal.fire({
                    title: "Confirmed!",
                    text: "The Appointment has been Confirmed.",
                    icon: "success"
                });
            }
        });
    }
</script>



<script>
    function cancelAppointment(ev)
    {
        ev.preventDefault();

        var UrlToRedirect = ev.currentTarget.getAttribute('href');

        Swal.fire({
        title: "Are you sure you?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Confirm it!"
        }).then((result) => {
            if (result.isConfirmed) {

                ev.target.closest('form').submit();
                Swal.fire({
                    title: "Confirmed!",
                    text: "The Appointment has been Cancelled.",
                    icon: "success"
                });
            }
        });
    }
</script>



<script>
    function progressAppointment(ev)
    {
        ev.preventDefault();

        var UrlToRedirect = ev.currentTarget.getAttribute('href');

        Swal.fire({
        title: "Are you sure you?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Confirm it!"
        }).then((result) => {
            if (result.isConfirmed) {

                ev.target.closest('form').submit();
                Swal.fire({
                    title: "Confirmed!",
                    text: "The Appointment has been set to In Progress.",
                    icon: "success"
                });
            }
        });
    }
</script>