import { getPosts } from '../../services/PostService';
import PostHeader from './PostHeader';
import PostContent from './PostContent';
import moment from 'moment/moment';
import { __ } from '@wordpress/i18n';
import NewPostForm from '../forms/NewPostForm';
import { YS_GROUP_TEXT_DOMAIN } from '../../constants/constatnts';

const { useState, useEffect } = wp.element;

/**
 * Affichage des publications
 *
 * @returns {JSX.Element}
 * @constructor
 * @since 1.2.5
 */
function Posts () {
  const [posts, setPosts] = useState([]);
  const [isMounted, setIsMounted] = useState(false);

  useEffect(() => {
    !isMounted && getPosts()
      .then((jsonPosts) => {
        console.log(jsonPosts);
        setPosts(jsonPosts);
        setIsMounted(true);
      });
  }, [isMounted]);

  if (posts) {
    return (
      <div className="ys-group-posts">
        <NewPostForm/>
        {posts.map((post) => (
          <div className="post">
            <PostHeader
              authorAvatar={post.author.avatar_image}
              authorFullname={post.author.fullname}
              postDate={moment(post.date).fromNow()}
              profilUrl={post.author.profile_url}
            />
            <PostContent
              content={post.content}
              postFeaturedImage={post.featured_image.thumbnail}
              postTitle={post.title}
            />
          </div>
        ))}
      </div>
    );
  } else {
    return (
      <div className="ys-group-posts">
        <p className="post">{__('No post for now', YS_GROUP_TEXT_DOMAIN)}</p>
      </div>
    );
  }
}

export default Posts;
