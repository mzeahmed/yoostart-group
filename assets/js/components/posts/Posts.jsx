import { __ } from '@wordpress/i18n';
import { useEffect, useState } from 'react';
import { YS_GROUP_TEXT_DOMAIN } from '../../constants/constants';
import { getPosts } from '../../services/PostService';
import NewPostForm from '../forms/NewPostForm';
import PostPreview from './content/PostPreview';

/**
 * Affichage des publications
 *
 * @returns {JSX.Element}
 * @constructor
 * @since 1.2.5
 */
function Posts () {
  const [isPending, setIsPending] = useState(false);
  const [error, setError] = useState(null);
  const [posts, setPosts] = useState([]);

  useEffect(() => {
    getPosts()
      .then((data) => {
        setIsPending(true);
        setPosts(data);
        setError(null);
      }).catch((error) => {
      setIsPending(true);
      setError(error.message);
    });
  }, []);

  const handleAdd = (post) => {
    setPosts((existing) => [...existing, post]);
  };

  if (error) {
    return (
      <>
        <NewPostForm onSave={handleAdd}/>

        <div className="ys-group-posts">
          <p className="post">{__('No post for now', YS_GROUP_TEXT_DOMAIN)}</p>
        </div>
      </>
    );
  } else if (!isPending) {
    return (
      <div className="ys-group-posts-loader text-center">{__('Loading...', YS_GROUP_TEXT_DOMAIN)}</div>
    );
  } else {
    return (
      <div className="ys-group-posts">
        <NewPostForm onSave={handleAdd}/>
        {posts.map((post) => (
          <div className="post">
            {/* <PostHeader */}
            {/*   authorAvatar={post.author.avatar_image} */}
            {/*   authorFullname={post.author.fullname} */}
            {/*   postDate={moment(post.date).fromNow()} */}
            {/*   profilUrl={post.author.profile_url} */}
            {/* /> */}
            {/* <PostContent */}
            {/*   content={post.content} */}
            {/*   postFeaturedImage={post.featured_image.thumbnail} */}
            {/*   postTitle={post.title} */}
            {/* /> */}
            {/* <PostFooter postId={post.id}/> */}

            <PostPreview
              key={post.id}
              {...post}
            />
          </div>
        ))}
      </div>
    );
  }
}

export default Posts;
