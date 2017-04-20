    <div id="top">
        <div class="container">
            <div class="col-md-6 offer" data-animate="fadeInDown">
                <a href="#" class="btn btn-success btn-sm" data-animate-hover="shake"><i class="fa fa-phone"></i> 090 686 46 48</a>  
                <!-- <a href="#">Get flat 35% off on orders over $50!</a> -->
                <a href="#"><i class="fa fa-envelope"></i>direclassic2016@yahoo.com</a>
            </div>
            <div class="col-md-6" data-animate="fadeInDown">
                <ul class="menu">
<!--                     <li><a href="#" data-toggle="modal" data-target="#login-modal">Login</a>
                    </li>
                    <li><a href="register.html">Register</a>
                    </li> -->
                    <li><a href="https://www.facebook.com/Dir%C3%AA-Classic-Corporation-1760743330915704/" target="_blank"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li><a href="<?php echo base_url('lien-he'); ?>">Liên Hệ</a>
                    </li>                   
                </ul>
            </div>
        </div>


        <!-- form login , tuy nhiên menu login ở trên đa comment -->
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
            <div class="modal-dialog modal-sm">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="Login">Customer login</h4>
                    </div>
                    <div class="modal-body">
                        <form action="customer-orders.html" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" id="email-modal" placeholder="email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password-modal" placeholder="password">
                            </div>

                            <p class="text-center">
                                <button class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
                            </p>

                        </form>

                        <p class="text-center text-muted">Not registered yet?</p>
                        <p class="text-center text-muted"><a href="register.html"><strong>Register now</strong></a>! It is easy and done in 1&nbsp;minute and gives you access to special discounts and much more!</p>

                    </div>
                </div>
            </div>
        </div>

    </div>