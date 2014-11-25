<?php
$form = $this->form;
$form->prepare();
$form->setAttribute('action', $this->url('login'));
$form->setAttribute('method', 'POST');
$form->setAttribute('role', 'form');
$form->setAttribute('id', 'user-login');
?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h1 class="page-header">Login</h1>
            <?php echo $this->form()->openTag($form); ?>
            <?php
            $usernameMessages = $form->get('username')->getMessages();
            $passwordMessages = $form->get('password')->getMessages();
            ?>
            <div class="form-group <?php echo (!empty($usernameMessages)) ? 'has-error':''; ?>">
                <?php echo $this->formLabel($form->get('username')); ?>
                <?php echo $this->formElement($form->get('username')); ?>
            </div>
            <div class="form-group <?php echo (!empty($passwordMessages)) ? 'has-error':''; ?>">
                <?php echo $this->formLabel($form->get('password')); ?>
                <?php echo $this->formElement($form->get('password')); ?>
            </div>
            <?php echo $this->formHidden($form->get('security')); ?>
            <?php echo $this->formElement($form->get('submit')); ?>
            <?php echo $this->form()->closeTag(); ?>
        </div>
    </div>
</div>