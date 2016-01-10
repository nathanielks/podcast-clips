import React from 'react'
import Dropzone from 'react-dropzone'
import { filesDropped } from 'actions/files'
import { connect } from 'react-redux';

class PodcastClipsRoot extends React.Component {

  render() {
    const onDrop = (files) => {
      this.props.dispatch(filesDropped(files))
    }

    return (
        <div>
          <Dropzone onDrop={onDrop}>
            <div>Try dropping some files here, or click to select files to upload.</div>
          </Dropzone>
        </div>
        );
  }
}

const mapStateToProps = (state) => {
  return state
};

export default connect(
  mapStateToProps
)(PodcastClipsRoot);
