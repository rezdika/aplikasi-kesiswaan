<!-- Profile Modal -->
<div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="profileModalLabel"><i class="fas fa-user me-2"></i>Profil Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php $profile = auth()->user()->profileData; @endphp
                
                <div class="text-center mb-4">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="mb-1">{{ $profile['nama'] ?? auth()->user()->username }}</h5>
                    <span class="level-badge level-{{ auth()->user()->level }}">{{ ucfirst(str_replace('_', ' ', auth()->user()->level)) }}</span>
                </div>
                
                <div class="profile-info">
                    <div class="info-row">
                        <span class="info-label">Username</span>
                        <span class="info-value">{{ auth()->user()->username }}</span>
                    </div>
                    
                    @if($profile)
                        @if(auth()->user()->level == 'siswa')
                            <div class="info-row">
                                <span class="info-label">NIS</span>
                                <span class="info-value">{{ $profile['identifier'] }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Kelas</span>
                                <span class="info-value">{{ $profile['kelas'] }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Jenis Kelamin</span>
                                <span class="info-value">{{ $profile['jenis_kelamin'] }}</span>
                            </div>
                        @elseif(in_array(auth()->user()->level, ['guru', 'bk', 'wali_kelas']))
                            <div class="info-row">
                                <span class="info-label">NIP</span>
                                <span class="info-value">{{ $profile['identifier'] }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Bidang Studi</span>
                                <span class="info-value">{{ $profile['bidang_studi'] }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status</span>
                                <span class="info-value">{{ ucfirst($profile['status']) }}</span>
                            </div>
                        @elseif(auth()->user()->level == 'ortu')
                            <div class="info-row">
                                <span class="info-label">Hubungan</span>
                                <span class="info-value">{{ ucfirst($profile['hubungan']) }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Pekerjaan</span>
                                <span class="info-value">{{ $profile['pekerjaan'] }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">No. Telp</span>
                                <span class="info-value">{{ $profile['no_telp'] }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Anak</span>
                                <span class="info-value">{{ $profile['siswa'] }}</span>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Tutup</button>
            </div>
        </div>
    </div>
</div>