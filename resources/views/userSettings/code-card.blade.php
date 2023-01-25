<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>

<div class="modal fade" id="codeModal" tabindex="-1" role="dialog" aria-labelledby="codeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-header text-center" style="background-color: #8f9c9f; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                        <h5 class="card-title" style="color: white;">Codes</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                            @foreach ($codes as $index => $code)
                                <tr>
                                    <th scope="row">{{ $index }}</th>
                                    <td>{{ $code }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <x-button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 30px">Close</x-button>
            </div>
        </div>
    </div>
</div>
