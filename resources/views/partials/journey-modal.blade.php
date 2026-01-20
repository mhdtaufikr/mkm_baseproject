<div class="modal fade" id="journeyModal{{ $data->id }}" tabindex="-1"
    aria-labelledby="journeyModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="journeyModalLabel{{ $data->id }}">Checksheet Journey</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($data->journeyLogs && $data->journeyLogs->isEmpty())
                    <p>No journey logs available for this checksheet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table-bordered table-striped table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Remark</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->journeyLogs as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $log->user->name }}</td>
                                        <td>
                                            @if ($log->action == -1)
                                                <span class="badge bg-primary">Create</span>
                                            @elseif($log->action == 0)
                                                <span class="badge bg-info">Submit</span>
                                            @elseif($log->action == 1)
                                                <span class="badge bg-warning">Check</span>
                                            @elseif($log->action == 3)
                                                <span class="badge bg-danger">Remand</span>
                                            @elseif($log->action == 2)
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown Status</span>
                                            @endif
                                        </td>

                                        <td>{{ $log->remark }}</td>
                                        <td>{{ $log->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
