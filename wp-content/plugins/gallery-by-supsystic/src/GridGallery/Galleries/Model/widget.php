<?php
class sggWidget extends Wp_Widget {

    private $gallery;

    /**
     * Register widget with WordPress.
     */
    function __construct() {

        $this->gallery = new GridGallery_Galleries_Model_Galleries();
        parent::__construct(
            'sggWidget',
            'Gallery by Supsystic Widget',
            array( 'description' => 'Gallery by Supsystic plugin' )
        );

    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        echo do_shortcode('[supsystic-gallery id=' . $instance['gallery_id'] . ' position="center"]');
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = 'Title';
        }

        $id = array();
        
        foreach($this->gallery->getList() as $gallery) {
            array_push($id, array(
                'name' => $gallery->title . ' ' . $gallery->id,
                'value' => $gallery->id
            ));
        }

        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            <label for="<?php echo $this->get_field_id( 'gallery_id' ); ?>"><?php _e( 'Select gallery: ' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'gallery_id' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gallery_id' ); ?>" type="text">
                <?php foreach($id as $element)
                    if(isset($instance['gallery_id']) && $instance['gallery_id'] == $element['value']) {
                        echo "<option value=" . $element['value'] . " selected>". $element['name'] . "</option>";
                    } else {
                        echo "<option value=" . $element['value'] . ">". $element['name'] . "</option>";
                    }
                ?>
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['gallery_id'] = ( ! empty( $new_instance['gallery_id'] ) ) ? strip_tags( $new_instance['gallery_id'] ) : '';

        return $instance;
    }
}