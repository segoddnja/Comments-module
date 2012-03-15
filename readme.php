This module helps to add comments to any instance of CActiveRecord.
To add a comment to the model, you need to perform the following steps.

Add Comments table to your schema:

CREATE TABLE IF NOT EXISTS `tbl_comments` (
    `owner_name` varchar(50) NOT NULL,
    `owner_id` int(12) NOT NULL,
    `comment_id` int(12) NOT NULL AUTO_INCREMENT,
    `parent_comment_id` int(12) DEFAULT NULL,
    `creator_id` int(12) DEFAULT NULL,
    `user_name` varchar(128) DEFAULT NULL, 
    `user_email` varchar(128) DEFAULT NULL,
    `comment_text` text,
    `create_time` int(11) DEFAULT NULL,
    `update_time` int(11) DEFAULT NULL,
    `status` int(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`comment_id`),
    KEY `owner_name` (`owner_name`,`owner_id`)
    )

Configure the module in app config:

'modules'=>array(
    ...
    'comments'=>array(
        //you may override default config for all connecting models
        'defaultModelConfig' => array(
            //only registered users can post comments
            'registeredOnly' => false,
            'useCaptcha' => false,
            //allow comment tree
            'allowSubcommenting' => true,
            //display comments after moderation
            'premoderate' => false,
            //action for postig comment
            'postCommentAction' => 'comments/comment/postComment',
            //super user condition(display comment list in admin view and automoderate comments)
            'isSuperuser'=>'false',
            //order direction for comments
            'orderComments'=>'DESC',
        ),
        //the models for commenting
        'commentableModels'=>array(
            //model with individual settings
            'Citys'=>array(
                'registeredOnly'=>true,
                'useCaptcha'=>true,
                'allowSubcommenting'=>false,
                //config for create link to view model page(page with comments)
                'pageUrl'=>array(
                    'route'=>'admin/citys/view',
                    'data'=>array('id'=>'city_id'),
                ),
            ),
            //model with default settings
            'ImpressionSet',
        ),
        //config for user models, which is used in application
        'userConfig'=>array(
            'class'=>'User',
            'nameProperty'=>'username',
            'emailProperty'=>'email',
        ),
    ),
    ...
),

Display ECommentListWidget in view for displaying commentable models

$this->widget('comments.widgets.ECommentsListWidget', array(
    'model' => $model,
));

To manage all comments go to http://yoursite.com/modules.