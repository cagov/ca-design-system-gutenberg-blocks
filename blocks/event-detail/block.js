/**
 * CAGov Event Detail
 * Developer note: Reminder to run npm start & npm run build to generate this component.
 */

 const {
  blocks,
  blockEditor,
  i18n,
  element,
  components,
  date,
  data,
  compose,
  api
} = wp;
const { moment, _ } = window;

const { dateI18n } = date;
const {
  DateTimePicker,
  DatePicker,
  Popover,
  Button,
  PanelRow,
  TextControl,
  Panel,
  PanelBody,
  Placeholder,
	Spinner,
} = components;

const { Fragment, useState, useEffect, createElement, Component } = element;
const { InspectorControls, RichText, InnerBlocks } = blockEditor;
const { useSelect, useDispatch } = data;
const { withState } = compose;

var __ = i18n.__;
var el = createElement;

var defaultDate = new Date();
var formattedDate = moment(defaultDate).format("MMMM DD, YYYY");
var formattedTime = moment(defaultDate).startOf('hour').format("hh:mm a");
var formattedTimePlusHour = moment(defaultDate).startOf('hour').add(moment.duration(1, 'hours')).format("hh:mm a");

class OptionsExample extends Component {
	constructor() {
		super( ...arguments );
		this.state = { 
      exampleText: '',
      isAPILoaded: false,
     };
	}

  componentDidMount() {

    data.subscribe( () => {
      const { exampleText } = this.state;
    
      const isSavingPost = data.select('core/editor').isSavingPost();
      const isAutosavingPost = data.select('core/editor').isAutosavingPost();
    
      if ( isAutosavingPost ) {
        return;
      }
    
      if ( ! isSavingPost ) {
        return;
      }
    
      const settings = new api.models.Settings( {
        [ 'cagov_event_detail_example_text' ]: exampleText,
      } );
      settings.save();
    });


    api.loadPromise.then( () => {
      this.settings = new api.models.Settings();
      
      const { isAPILoaded } = this.state;
  
      if ( isAPILoaded === false ) {
        this.settings.fetch().then( ( response ) => {
          this.setState( {
            exampleText: response[ 'cagov_event_detail_plugin_example_text' ],
            isAPILoaded: true,
          } );
        } );
      }
    } );
  }

	render() {
		const {
      exampleText,
      isAPILoaded,
    } = this.state;
    
    const { setAttributes } = this.props;

    if ( ! isAPILoaded ) {
      return (
        <Placeholder>
          <Spinner />
        </Placeholder>
      );
    }

		return (
			<Panel>
				<PanelBody
					title={ __( 'Example Meta Box', 'cagov_event_detail' ) }
					icon="admin-plugins"
				>
					<TextControl
						help={ __( 'This is an example text field.', 'cagov-event-detail' ) }
						label={ __( 'Example Text', 'cagov_event_detail' ) }
						onChange={ ( exampleText ) => { this.setState( { exampleText } ); setAttributes( { exampleText } ) } }
						value={ exampleText }
					/>
				</PanelBody>
			</Panel>
		)
	}
}

// export default function Edit( props ) {
// 	return (
// 		<div { ...useBlockProps() }>
// 			<OptionsExample { ...props }/>
// 		</div>
// 	);
// }

blocks.registerBlockType("ca-design-system/event-detail", {
  title: __("Event Detail", "ca-design-system"),
  icon: "format-aside",
  category: "ca-design-system-utilities",
  description: __("Block for details about an event"),
  attributes: {
    title: {
      type: "string",
      default: "Event Details",
    },
    startDate: {
      type: "string",
      // default: formattedDate,
    },
    endDate: {
      type: "string",
      // default: formattedDate,
    },
    startTime: {
      type: "string",
      // default: formattedTime
    },
    endTime: {
      type: "string",
      // default: formattedTimePlusHour
    },
    location: {
      type: "string",
    },
    cost: {
      type: "string",
    }
  },
  example: {
    attributes: {
      title: "Event Details"
    },
  },
  edit: function (props) {

    const [openDatePopup, setOpenDatePopup] = useState(false);
    var attributes = props.attributes;

    const { title, startDate, endDate, startTime, endTime, location, cost } = props.attributes;

    // https://developer.wordpress.org/block-editor/reference-guides/components/date-time/

    return (
      <div>
        <RichText
          value={title}
          tagName="h2"
          className="title"
          onChange={(title) => props.setAttributes({ title })}
          placeholder={__("Event Details", "ca-design-system")}
        />

        <div className="cagov-grid cagov-event-detail cagov-stack cagov-block">
          <div class="detail-section">
            <h4>{__("Date & time", "ca-design-system")}</h4>

            <RichText
              value={startDate}
              tagName="div"
              className="startDate"
              value={startDate}
              onChange={(startDate) => props.setAttributes({ startDate })}
              placeholder={__(formattedDate, "ca-design-system")}
            />

            <RichText
              value={endDate}
              tagName="div"
              className="endDate"
              value={endDate}
              onChange={(endDate) => props.setAttributes({ endDate })}
              placeholder={__(formattedDate, "ca-design-system")}
            />

            <RichText
              value={startTime}
              tagName="div"
              className="startTime"
              value={startTime}
              onChange={(startTime) => props.setAttributes({ startTime })}
              placeholder={__(formattedTime, "ca-design-system")}
            />

            <RichText
              value={endTime}
              tagName="div"
              className="endTime"
              value={endTime}
              onChange={(endTime) => props.setAttributes({ endTime })}
              placeholder={__(formattedTimePlusHour, "ca-design-system")}
            />
          </div>
          <div class="detail-section">

            <h4>{__("Location", "ca-design-system")}</h4>

            <RichText
              value={location}
              tagName="div"
              className="location"
              value={location}
              onChange={(location) => props.setAttributes({ location })}
              placeholder={__("Enter text...", "ca-design-system")}
            />

          </div>

          <div class="detail-section">
            <h4>{__("Cost", "ca-design-system")}</h4>

            <RichText
              value={cost}
              tagName="div"
              className="cost"
              value={cost}
              onChange={(cost) => props.setAttributes({ cost })}
              placeholder={__("Enter text...", "ca-design-system")}
            />

          </div>
          <div class="detail-section-more-info">
            {el(InnerBlocks,
              {
                orientation: 'horizontal',
                allowedBlocks: ["core/paragraph", "core/button"],
              }
            )}
          </div>
        </div>
      </div>
    );
  },
  save: function (props) {
    return el(
      'div',
      { className: 'wp-block-ca-design-system-event-detail cagov-event-detail cagov-stack' },
      el(InnerBlocks.Content)
    );
  }

  // Checks we need to do:
  // - 
  // https://bebroide.medium.com/how-to-easily-develop-with-react-your-own-custom-fields-within-gutenberg-wordpress-editor-b868c1e193a9

  // Sync date and time field with post custom field data.
  // data.subscribe(function () {
  //   var blocks = data.select("core/block-editor").getBlocks();

  //   var isPostDirty = data.select("core/editor").isEditedPostDirty();
  //   var isAutosavingPost = data.select("core/editor").isAutosavingPost();

  //   if (isPostDirty && !isAutosavingPost) {
  //     blocks.map((block) => {
  //       if (block.name === "ca-design-system/cagov-event-detail") {
  //         let eventDetailBlock = data
  //           .select("core/block-editor")
  //           .getBlocksByClientId(block.clientId);

  //         console.log(eventDetailBlock);
        

  //         eventDetailBlock.map((localBlock) => {
  //           if (
      
  //             localBlock.attributes !== undefined &&
  //             localBlock.attributes.label !== null &&
  //             // typeof updatedSelectedCategory[0].name === "string"
  //           ) {
  //             console.log("updating", localBlock);

   
  //           }
  //         });
  //       }
  //     });
  //   }
  // });

});
