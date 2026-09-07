// $(document).ready(function () {
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $('#csvFile').on('change', function () {
//         var file = this.files[0];
//
//         if (!file) {
//             return;
//         }
//
//         var formData = new FormData();
//         formData.append('file', file);
//
//
//         $('#loadingStatus').show();
//         $('#resultContainer, #noResult').hide();
//         $('#resultGrid').empty();
//
//         $.ajax({
//             url: "/upload",
//             type: "POST",
//             data: formData,
//             processData: false,
//             contentType: false,
//             success: function (response) {
//                 $('#loadingStatus').hide();
//
//                 if (response && response.length > 0) {
//                     for (var i = 0; i < response.length; i++) {
//                         var row = response[i];
//
//                         var htmlRow = '<tr style="border-bottom: 1px solid #ddd;">' +
//                             '<td style="padding: 12px; border: 1px solid #ddd;">' + row.member1 + '</td>' +
//                             '<td style="padding: 12px; border: 1px solid #ddd;">' + row.member2 + '</td>' +
//                             '<td style="padding: 12px; border: 1px solid #ddd;">' + row.projectId + '</td>' +
//                             '<td style="padding: 12px; border: 1px solid #ddd; font-weight: bold; color: #2b6cb0;">' + row.days + ' days</td>' +
//                             '</tr>';
//
//                         $('#resultGrid').append(htmlRow);
//                     }
//                     $('#resultContainer').show();
//                 } else {
//                     $('#noResult').show();
//                 }
//             },
//             error: function (xhr) {
//                 $('#loadingStatus').hide();
//                 alert('Something went wrong, check the console');
//                 console.log(xhr.responseText);
//             }
//         });
//     });
// });
//

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $('#csvFile').change(function() {
        var file = this.files[0];

        if (!file) {
            return;
        }

        var formData = new FormData();

        formData.append('file', file);

        $('#loadingStatus').show();
        $('#resultContainer').hide();
        $('#noResult').hide();
        $('#resultGrid').empty();

        $.ajax({
            url: '/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {
                $('#loadingStatus').hide();

                if (response.length === 0) {
                    $('#noResult').show();
                    return;
                }

                for (var i = 0; i < response.length; i++) {

                    var row = response[i];

                    var html = '<tr>' +
                        '<td>' + row.member1 + '</td>' +
                        '<td>' + row.member2 + '</td>' +
                        '<td>' + row.projectId + '</td>' +
                        '<td>' + row.days + ' days</td>' +
                        '</tr>';

                    $('#resultGrid').append(html);
                }

                $('#resultContainer').show();
            },

            error: function (xhr) {
                $('#loadingStatus').hide();
                console.log(xhr.responseText);
                alert('Something went wrong');
            }
        })
    })
})
