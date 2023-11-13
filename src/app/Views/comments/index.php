<!DOCTYPE html>
<?php 
    helper('form'); 
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="scripts.js"></script>
</head>

<header>
    <ul>
        <li class="menu-item">
            
        </li>
    </ul>
</header>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-lg-3"> </div>
        <div class="col-lg-6">
            <form action="/comment" id="comment" method="post">
                <input type="hidden" id="csrf" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="<?= isset($email) ? $email : ''?>" required>
                </div>
                <div class="form-group">
                    <label for="text">Comment</label>
                    <textarea id="text" name="text" class="form-control" rows="3" ><?= isset($text) ? $text : ''?></textarea>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3"> </div>
        <div class="col-lg-6">
            <div id='errors-field' class='alert alert-danger mt-2' <?= isset($errors) ? '' : 'hidden' ?>>
                <ul id="errors-list">
                    
                </ul>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-3">
        </div>
        <div class="col-md-2">
            <input class="btn btn-primary btn-block" form="comment" type="submit" value="Send">
        </div>
        <div class="col-md-2">
            <input class="btn btn-danger btn-block" form="comment" type="reset" value="Cancel">
        </div>
    </div>
    <div class="row mb-3 border-top">
            <div class="col-sm-9">
                <a id="id-up" href="/?page=<?= $comments['pager']->getCurrentPage() ?>&order=1" class="font-weight-bold" <?= $order == 1 ? "hidden" : ""?>>Comment</a>
                <a id="id-down" href="/?page=<?= $comments['pager']->getCurrentPage() ?>&order=2" class="font-weight-bold" <?= $order == 1 ? "" : "hidden" ?>>Comment ↓</a>
            </div>
            <div class="col-sm-3">
                <a id="date-up" href="/?page=<?= $comments['pager']->getCurrentPage() ?>&order=3" class="font-weight-bold"<?= $order == 3 ? "hidden" : "" ?>>Date</a>
                <a id="date-up" href="/?page=<?= $comments['pager']->getCurrentPage() ?>&order=4" class="font-weight-bold"<?= $order == 3 ? "" : "hidden" ?>>Date ↓</a>
            </div>
    </div>
    <div id="comments-block">
    <?php if(isset($comments)) {
        foreach($comments['comments'] as $comment){?>
        <div class="row mb-3 border-top">
            <div class="col-lg-9">
                <p><?= $comment['id'].". ".$comment['email'] ?></p>
                <p><?= $comment['text'] ?></p>
            </div>
            <div class="col-lg-3">
                <p><?= $comment['created_at'] ?></p>
                <form class="delete-form" action="comment/<?= $comment['id'] ?>" method="DELETE">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
        <?php }
    }?>
    </div>
    
    <div class="row mb-3 pt-2 border-top">
        <nav aria-label="Page navigation">
            <ul class="pagination">
            <?php if ($comments['pager']->getPreviousPageURI()) : ?>
                <li class="mr-2">
                    <a href="/?page=1" aria-label="<?= lang('Pager.first') ?>">
                        <span aria-hidden="true"><?= lang('Pager.first') ?></span>
                    </a>
                </li>
                <li class="mr-2">
                    <a href="<?= $comments['pager']->getPreviousPageURI() ?>" aria-label="<?= $comments['pager']->getCurrentPage()-1 ?>">
                        <span aria-hidden="true"><?= $comments['pager']->getCurrentPage()-1 ?></span>
                    </a>
                </li>
            <?php endif ?>

                <li class="mr-2">
                    <a href="/?page=<?= $comments['pager']->getCurrentPage() ?>" aria-label="<?= $comments['pager']->getCurrentPage() ?>">
                        <span aria-hidden="true"><?= $comments['pager']->getCurrentPage() ?></span>
                    </a>
                </li>
                
            <?php if ($comments['pager']->getNextPageURI()) : ?>
                <li class="mr-2">
                    <a href="<?= $comments['pager']->getNextPageURI() ?>" aria-label="<?= $comments['pager']->getCurrentPage()+1 ?>">
                        <span aria-hidden="true"><?= $comments['pager']->getCurrentPage()+1 ?></span>
                    </a>
                </li>
                <li>
                    <a href="/?page=<?= $comments['pager']->getLastPage() ?>" aria-label="<?= lang('Pager.last') ?>">
                        <span aria-hidden="true"><?= lang('Pager.last') ?></span>
                    </a>
                </li>
            <?php endif ?>
            </ul>
        </nav>
    </div>
</div>

<footer>
	<div class="copyrights">

		<p>&copy; <?= date('Y') ?> CodeIgniter Foundation. CodeIgniter is open source project released under the MIT
			open source licence.</p>

	</div>

</footer>
</body>
</html>
