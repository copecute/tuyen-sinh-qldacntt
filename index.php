<?php
//                       _oo0oo_
//                      o8888888o
//                      88" . "88
//                      (| -_- |)
//                      0\  =  /0
//                    ___/`---'\___
//                  .' \\|     |// '.
//                 / \\|||  :  |||// \
//                / _||||| -:- |||||- \
//               |   | \\\  -  /// |   |
//               | \_|  ''\---/''  |_/ |
//               \  .-\__  '-'  ___/-. /
//             ___'. .'  /--.--\  `. .'___
//          ."" '<  `.___\_<|>_/___.' >' "".
//         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
//         \  \ `_.   \_ __\ /__ _/   .-` /  /
//     =====`-.____`.___ \_____/___.-`___.-'=====
//                       `=---='
//
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//            amen đà phật copecute 
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

renderHeader("Tuyển sinh Trường Cao đẳng Công nghệ Bách khoa Hà Nội");
?>


<div class="banner-area-one shape-move">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 order-xl-1 order-lg-1 order-sm-2 order-2">
                <div class="banner-content-one">
                    <div class="inner">
                        <div class="pre-title-banner">
                            <img src="/resources/images/banner/bulb.png" width="22" alt="icon">
                            <span>HPC - LỰA CHỌN ĐÚNG - LÃI TƯƠNG LAI</span>
                        </div>
                        <h1 class="title-banner">
                            Khám Phá Tiềm Năng của Bạn với
                            <span>trường HPC</span>
                            <img src="/resources/images/banner/02.png" alt="banner">
                        </h1>
                        <p class="disc">Hãy khám phá thế giới kiến thức và cơ hội với nền tảng giáo dục trực tuyến của
                            chúng tôi. Định hướng cho sự nghiệp mới hoặc nâng cao trình độ của bạn với các chương trình
                            đào tạo chất lượng cao, phù hợp với nhu cầu và thời gian của bạn.</p>
                        <div class="banner-btn-author-wrapper">
                            <a href="/tuyensinh.php" class="rts-btn btn-primary with-arrow">Xét tuyển ngay <i
                                    class="fa-regular fa-arrow-right"></i></a>
                            <div class="sm-image-wrapper">
                                <div class="images-wrap">
                                    <img src="/resources/images/banner/shape/06.png" alt="banner">
                                    <img class="two" src="/resources/images/banner/shape/07.png" alt="banner">
                                    <img class="three" src="/resources/images/banner/shape/08.png" alt="banner">
                                </div>
                                <div class="info">
                                    <h6 class="title">hơn 10k sinh viên</h6>
                                    <span>Tham gia lớp học ngay nào</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order--xl-2 order-lg-2 order-sm-1 order-1">
                <div class="banner-right-img">
                    <img src="/resources/images/111_8092-removebg-preview-20230630071540-m_ood.png" alt="banner">
                </div>
            </div>
        </div>
    </div>
    <div class="review-thumb">
        <!-- single review -->
        <div class="review-single">
            <img src="/resources/images/banner/03.png" alt="banner">
            <div class="info-right">
                <p class="title">100%</p>
                <span>Tốt nghiệp có việc làm</span>
            </div>
        </div>
        <!-- single review end -->
        <!-- single review -->
        <div class="review-single two">
            <img src="/resources/images/banner/04.png" alt="banner">
            <div class="info-right">
                <p class="title">500+
                </p>
                <span>Đối tác trong nước và quốc tế</span>
            </div>
        </div>
        <!-- single review end -->
    </div>
    <div class="shape-image">
        <div class="shape one" data-speed="0.04" data-revert="true"><img
                src="/resources/images/banner/shape/banner-shape01.svg" alt="shape_image"></div>
        <div class="shape two" data-speed="0.04"><img src="/resources/images/banner/shape/banner-shape02.svg"
                alt="shape_image"></div>
        <div class="shape three" data-speed="0.04"><img src="/resources/images/banner/shape/banner-shape03.svg"
                alt="shape_image"></div>
    </div>
</div>
<script>
    function startIntro() {
        introJs().setOptions({
            steps: [{
                element: document.querySelector('#intro-step1'),
                intro: "Xin chào, trước tiên bạn hãy đăng ký xét tuyển!"
            }, {
                element: document.querySelector('#intro-step2'),
                intro: "Sau đó hãy tra cứu kết quả xét tuyển nhé!"
            }, {
                element: document.querySelector('#intro-step3'),
                intro: "Nếu bạn đã được phê duyệt hãy đăng nhập bằng tài khoản mà nhà trường cung cấp!"
            }]
        }).start();
    }

</script>
<?php renderFooter(); ?>