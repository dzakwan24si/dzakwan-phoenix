<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .hobby-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 5px 10px;
            border-radius: 20px;
            margin: 2px;
            display: inline-block;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">📊 Data Pegawai</h3>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Dasar -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>👤 Informasi Pribadi</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td>{{ $data['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Umur</strong></td>
                                        <td>{{ $data['my_age'] }} tahun</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Semester</strong></td>
                                        <td>
                                            <span class="badge bg-info">{{ $data['current_semester'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Cita-cita</strong></td>
                                        <td>🎯 {{ $data['future_goal'] }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>📅 Informasi Akademik</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Tanggal Wisuda</strong></td>
                                        <td>{{ $data['tgl_harus_wisuda'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jumlah Hari Lagi</strong></td>
                                        <td>
                                            @if($data['time_to_study_left'] > 0)
                                                <span class="badge bg-success">{{ $data['time_to_study_left'] }} hari</span>
                                            @else
                                                <span class="badge bg-danger">{{ abs($data['time_to_study_left']) }} hari terlambat</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Hobi -->
                        <div class="info-box">
                            <h5>🎨 Hobi</h5>
                            <div class="mt-2">
                                @foreach($data['hobbies'] as $hobby)
                                    <span class="hobby-badge">{{ $hobby }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pesan Semester -->
                        <div class="warning-box">
                            <h5>💡 Pesan Akademik</h5>
                            <p class="mb-0">{{ $data['semester_message'] }}</p>
                        </div>

                        <!-- Timeline -->
                        <div class="mt-4">
                            <h5>⏰ Timeline Studi</h5>
                            <div class="progress" style="height: 20px;">
                                @php
                                    $progress = min(($data['current_semester'] / 8) * 100, 100);
                                @endphp
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"
                                     aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                    Semester {{ $data['current_semester'] }} dari 8
                                </div>
                            </div>
                            <small class="text-muted">Progress menuju wisuda: {{ number_format($progress, 1) }}%</small>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        Data diperbarui pada: {{ date('d-m-Y H:i:s') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
