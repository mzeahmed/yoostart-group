import { __ } from '@wordpress/i18n';
import moment from 'moment/moment';
import { useEffect, useState } from 'react';
import { YS_GROUP_GET_POSTS_ENDPOINT, YS_GROUP_JWT, YS_GROUP_TEXT_DOMAIN } from '../../constants/constants';
import NewPostForm from '../forms/NewPostForm';
import PostContent from './content/PostContent';
import PostFooter from './footer/PostFooter';
import PostHeader from './header/PostHeader';

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
    fetch(YS_GROUP_GET_POSTS_ENDPOINT, {
      headers: {
        'Authorization': ` Bearer ${YS_GROUP_JWT}`
      }
    })
      .then((res) => {
        if (!res.ok) {
          throw Error(__('Could not fetch the data for that resource', YS_GROUP_TEXT_DOMAIN));
        }
        return res.json();
      })
      .then((data) => {
        setIsPending(true);
        setPosts(data);
        setError(null);
      })
      .catch((error) => {
        setIsPending(true);
        setError(error.message);
      });
  }, []);

  // console.log(posts);

  if (error) {
    return (<>
      <NewPostForm/>

      <div className="ys-group-posts">
        <p className="post">{__('No post for now', YS_GROUP_TEXT_DOMAIN)}</p>
      </div>
    </>);
  } else if (!isPending) {
    return (<div className="ys-group-posts-loader text-center">{__('Loading...', YS_GROUP_TEXT_DOMAIN)}</div>);
  } else {
    return (<div className="ys-group-posts">
      <NewPostForm/>
      {posts.map((post) => (<div className="post">
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
        <PostFooter postId={post.id}/>
      </div>))}
    </div>);
  }
}

export default Posts;
