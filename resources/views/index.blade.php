<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>WEB Kesiswaan</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-digimedia-v3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animated.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
<!--

TemplateMo 568 DigiMedia

https://templatemo.com/tm-568-digimedia

-->
  </head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
   @include('partials.header')
  <!-- ***** Header Area End ***** -->

  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                <div class="row">
                  <div class="col-lg-12">
                    <h6>Web Kesiswaan</h6>
                    <h2>Catatan Prestasi dan Pelanggaran</h2>
                    <p>Web ini menyediakan catatan prestasi, dan juga menyediakan catatan pelanggaran yang pernah dilakukan oleh siswa-siswi Bakti Nusantara 666</p>
                  </div>
                  <div class="col-lg-12">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                <img src="assets/images/slider-dec-v3.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="about" class="about section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6">
              <div class="about-left-image  wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.5s">
                <img src="assets/images/about-dec-v3.png" alt="">
              </div>
            </div>
            <div class="col-lg-6 align-self-center  wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
              <div class="about-right-content">
                <div class="section-heading">
                  <h6>Statistik</h6>
                  <h4>Data <em>Kesiswaan</em></h4>
                  <div class="line-dec"></div>
                </div>
                <p>Berikut adalah statistik data kesiswaan SMK Bakti Nusantara 666</p>
                <div class="row">
                  <div class="col-lg-4 col-sm-4">
                    <div class="skill-item first-skill-item wow fadeIn" data-wow-duration="1s" data-wow-delay="0s">
                      <div class="progress" data-percentage="100">
                        <span class="progress-left">
                          <span class="progress-bar"></span>
                        </span>
                        <span class="progress-right">
                          <span class="progress-bar"></span>
                        </span>
                        <div class="progress-value">
                          <div>
                            {{ $totalSiswa }}<br>
                            <span>Total Siswa</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-4">
                    <div class="skill-item second-skill-item wow fadeIn" data-wow-duration="1s" data-wow-delay="0s">
                      <div class="progress" data-percentage="{{ $persentaseSiswaBerprestasi }}">
                        <span class="progress-left">
                          <span class="progress-bar"></span>
                        </span>
                        <span class="progress-right">
                          <span class="progress-bar"></span>
                        </span>
                        <div class="progress-value">
                          <div>
                            {{ $persentaseSiswaBerprestasi }}%<br>
                            <span>Siswa Berprestasi</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-4">
                    <div class="skill-item third-skill-item wow fadeIn" data-wow-duration="1s" data-wow-delay="0s">
                      <div class="progress" data-percentage="{{ $persentaseSiswaBaik }}">
                        <span class="progress-left">
                          <span class="progress-bar"></span>
                        </span>
                        <span class="progress-right">
                          <span class="progress-bar"></span>
                        </span>
                        <div class="progress-value">
                          <div>
                            {{ $persentaseSiswaBaik }}%<br>
                            <span>Siswa Tanpa Pelanggaran</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="services" class="services section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading  wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
            <h6>Data Kesiswaan</h6>
            <h4>Informasi <em>Lengkap</em></h4>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="naccs">
            <div class="grid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="menu">
                    <div class="first-thumb active">
                      <div class="thumb">
                        <span class="icon"><img src="assets/images/service-icon-01.png" alt=""></span>
                        Jenis Pelanggaran
                      </div>
                    </div>
                    <div>
                      <div class="thumb">                 
                        <span class="icon"><img src="assets/images/service-icon-02.png" alt=""></span>
                        Jumlah <br> Kelas
                      </div>
                    </div>
                    <div class="last-thumb">
                      <div class="thumb">                 
                        <span class="icon"><img src="assets/images/service-icon-03.png" alt=""></span>
                        Bimbingan Konseling
                      </div>
                    </div>
                  </div>
                </div> 
                <div class="col-lg-12">
                  <ul class="nacc">
                    <li class="active">
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="left-text">
                                <h4>Daftar Jenis Pelanggaran</h4>
                                <p>Berikut adalah daftar jenis pelanggaran yang berlaku di SMK Bakti Nusantara 666</p>
                                <div class="table-responsive">
                                  <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>No</th>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Kategori</th>
                                        <th>Poin</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @forelse($jenisPelanggaran ?? [] as $index => $jp)
                                      <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jp->nama_pelanggaran }}</td>
                                        <td>{{ $jp->kategori }}</td>
                                        <td>{{ $jp->poin }}</td>
                                      </tr>
                                      @empty
                                      <tr>
                                        <td colspan="4" class="text-center">Belum ada data</td>
                                      </tr>
                                      @endforelse
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="left-text">
                                <h4>Daftar Kelas</h4>
                                <p>Berikut adalah daftar kelas yang ada di SMK Bakti Nusantara 666</p>
                                <div class="table-responsive">
                                  <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>No</th>
                                        <th>Nama Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Wali Kelas</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @forelse($kelas ?? [] as $index => $k)
                                      <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $k->nama_kelas }}</td>
                                        <td>{{ $k->jurusan }}</td>
                                        <td>-</td>
                                      </tr>
                                      @empty
                                      <tr>
                                        <td colspan="4" class="text-center">Belum ada data</td>
                                      </tr>
                                      @endforelse
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="left-text">
                                <h4>Daftar Bimbingan Konseling</h4>
                                <p>Berikut adalah daftar bimbingan konseling yang telah dilakukan</p>
                                <div class="table-responsive">
                                  <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @forelse($bimbingan ?? [] as $index => $b)
                                      <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $b->siswa->nama_siswa ?? '-' }}</td>
                                        <td>{{ $b->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $b->status }}</td>
                                      </tr>
                                      @empty
                                      <tr>
                                        <td colspan="4" class="text-center">Belum ada data</td>
                                      </tr>
                                      @endforelse
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>          
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  



  <div id="portfolio" class="our-portfolio section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="section-heading wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
            <h6>Statistik Pelanggaran</h6>
            <h4>Pelanggaran Per <em>Semester</em></h4>
            <div class="line-dec"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid wow fadeIn" data-wow-duration="1s" data-wow-delay="0.7s">
      <div class="row">
        <div class="col-lg-12">
          <div class="loop owl-carousel" data-loop="false" data-autoplay="false" data-nav="false" data-dots="false" data-items="3">
            @forelse($pelanggaranPerSemester ?? [] as $data)
            <div class="item">
              <div class="portfolio-item">
                <div class="thumb" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; height: 200px;">
                  <div style="text-align: center; color: white;">
                    <h2 style="font-size: 3rem; margin: 0;">{{ $data->total_pelanggaran }}</h2>
                    <p style="margin: 0; font-size: 1rem;">Pelanggaran</p>
                  </div>
                </div>
                <div class="down-content">
                  <h4>{{ $data->tahun_ajaran }}</h4>
                  <span>Semester {{ $data->semester }}</span>
                </div>
              </div>
            </div>
            @empty
            <div class="item">
              <div class="portfolio-item">
                <div class="thumb" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 200px;">
                  <div style="text-align: center; color: #6c757d;">
                    <h2 style="font-size: 3rem; margin: 0;">0</h2>
                    <p style="margin: 0; font-size: 1rem;">Pelanggaran</p>
                  </div>
                </div>
                <div class="down-content">
                  <h4>Belum Ada Data</h4>
                  <span>Semester</span>
                </div>
              </div>
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="contact" class="contact-us section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
            <h6>Contact Us</h6>
            <h4>Get In Touch With Us <em>Now</em></h4>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
          <form id="contact" action="" method="post">
            <div class="row">
              <div class="col-lg-12">
                <div class="contact-dec">
                  <img src="assets/images/contact-dec-v3.png" alt="">
                </div>
              </div>
              <div class="col-lg-5">
                <div id="map">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666!2d106.816!3d-6.200!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDgnNTcuNiJF!5e0!3m2!1sen!2sid!4v1234567890" width="100%" height="636px" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="fill-form">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="info-post">
                        <div class="icon">
                          <img src="assets/images/phone-icon.png" alt="">
                          <a href="tel:+6221123456">(021) 123-4567</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="info-post">
                        <div class="icon">
                          <img src="assets/images/email-icon.png" alt="">
                          <a href="mailto:info@smkbn666.sch.id">info@smkbn666.sch.id</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="info-post">
                        <div class="icon">
                          <img src="assets/images/location-icon.png" alt="">
                          <a href="#">Jakarta, Indonesia</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <fieldset>
                        <input type="name" name="name" id="name" placeholder="Name" autocomplete="on" required>
                      </fieldset>
                      <fieldset>
                        <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email" required="">
                      </fieldset>
                      <fieldset>
                        <input type="subject" name="subject" id="subject" placeholder="Subject" autocomplete="on">
                      </fieldset>
                    </div>
                    <div class="col-lg-6">
                      <fieldset>
                        <textarea name="message" type="text" class="form-control" id="message" placeholder="Message" required=""></textarea>  
                      </fieldset>
                    </div>
                    <div class="col-lg-12">
                      <fieldset>
                        <button type="submit" id="form-submit" class="main-button ">Send Message Now</button>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  @include('partials.footer')


  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
  <script src="{{ asset('assets/js/animation.js') }}"></script>
  <script src="{{ asset('assets/js/imagesloaded.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  
  <style>
  /* Custom CSS untuk memusatkan statistik pelanggaran */
  .our-portfolio .section-heading {
    text-align: center;
    margin-bottom: 50px;
  }
  
  .our-portfolio .section-heading .line-dec {
    margin: 0 auto;
  }
  
  .our-portfolio .owl-stage {
    display: flex;
    justify-content: center;
  }
  </style>
  
  <script>
  $(document).ready(function() {
    $('.progress').each(function() {
      var $this = $(this);
      var percentage = $this.data('percentage');
      var $progressLeft = $this.find('.progress-left .progress-bar');
      var $progressRight = $this.find('.progress-right .progress-bar');
      
      if (percentage > 50) {
        $progressRight.css('transform', 'rotate(180deg)');
        $progressLeft.css('transform', 'rotate(' + ((percentage - 50) * 3.6) + 'deg)');
      } else {
        $progressRight.css('transform', 'rotate(' + (percentage * 3.6) + 'deg)');
        $progressLeft.css('transform', 'rotate(0deg)');
      }
    });
  });
  </script>

</body>
</html>