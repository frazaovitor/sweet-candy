<?php

class GridGallery_Galleries_Model_Preview
{

    /**
     * Name of the field with the post id.
     */
    const POST_FIELD = 'grid_gallery_preview_post';

    /**
     * Output type of the post.
     */
    const POST_OUTPUT = ARRAY_A;

    /**
     * Post filter
     */
    const POST_FILTER = 'raw';

    /**
     * Sets the content of the preview post.
     * @param  string $content Post content.
     * @throws RuntimeException
     * @return int Post ID.
     */
    public function setPostContent($content)
    {
        if (null === $post = $this->getPost()) {
            throw new RuntimeException('Unable to create preview post.');
        }

        $post['post_content'] = $content;
        $post['post_status'] = 'draft';

        if (1 >= wp_update_post($post)) {
            throw new RuntimeException('Unable to update post content.');
        }

        return $post['ID'];
    }

    /**
     * Returns an array of the post fields.
     * @return array
     */
    protected function getPostFields()
    {
        return array(
            'post_status' => 'draft',
            'post_title' => 'Gallery Preview',
        );
    }

    /**
     * Creates a new post for the preview.
     * @return WP_Post|null
     */
    protected function createPost()
    {
        if (1 >= $postId = wp_insert_post($this->getPostFields())) {
            return null;
        }

        update_option(self::POST_FIELD, $postId);

        return get_post($postId, self::POST_OUTPUT, self::POST_FILTER);
    }

    /**
     * Returns an instance of the preview post.
     * @return WP_Post|null
     */
    protected function getPost()
    {
        $postId = get_option(self::POST_FIELD);

        if (false === $postId) {
            return $this->createPost();
        }

        $post = get_post((int)$postId, self::POST_OUTPUT, self::POST_FILTER);
		$postFields = $this->getPostFields();
        if (null === $post) {
            return $this->createPost();
        } elseif ($post['post_title'] !== $postFields['post_title']) {
            return $this->createPost();
        }

        return $post;
    }
}