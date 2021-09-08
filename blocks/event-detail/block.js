/**
 * CAGov Event Detail
 * Developer note:
 * Reminder to run npm start & npm run build to generate this component  (wp-scripts build also works)
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
const {
  InspectorControls,
  RichText,
  InnerBlocks,
  useBlockProps,
  AlignmentToolbar,
  BlockControls,
} = blockEditor;
const { useSelect, useDispatch } = data;
const { withState } = compose;

var __ = i18n.__;
var el = createElement;

var defaultDate = new Date();
var formattedDate = moment(defaultDate).format("MMMM DD, YYYY");
var formattedTime = moment(defaultDate).startOf("hour").format("hh:mm a");
var formattedTimePlusHour = moment(defaultDate)
  .startOf("hour")
  .add(moment.duration(1, "hours"))
  .format("hh:mm a");

  const [startDate, setStartDate] = useState(new Date());
  const [endDate, setEndDate] = useState(new Date());

const StartDateTimePicker = ({startDate}) => {
  

  return (
    <DateTimePicker
      currentDate={startDate}
      onChange={(newDate) => setStartDate(newDate)}
      is12Hour={true}
    />
  );
};

const EndDateTimePicker = ({endDate}) => {


  // const onUpdateDate = ( dateTime ) => {
  //   console.log("dateTime", dateTime);
  //   var newDateTime = moment(dateTime).format( 'YYYY-MM-DD HH:mm' );
  //   setAttributes( { datetime: newDateTime } );
  // };

  return (
    <DateTimePicker
      currentDate={endDate}
      onChange={(newDate) => setEndDate(newDate)}
      is12Hour={true}
    />
  );
};

// class OptionsExample extends Component {
//   constructor() {
//     super(...arguments);

//     this.state = {
//       exampleText: "",
//       isAPILoaded: false,
//     };
//   }

//   // https://developer.wordpress.org/block-editor/reference-guides/components/date-time/

//   componentDidMount() {

//     data.subscribe(() => {
//       const { exampleText } = this.state;

//       const isSavingPost = data.select("core/editor").isSavingPost();
//       const isAutosavingPost = data.select("core/editor").isAutosavingPost();

//       if (isAutosavingPost) {
//         return;
//       }

//       if (!isSavingPost) {
//         return;
//       }

//       const settings = new window.wp.api.models.Settings({
//         ["cagov_event_detail_example_text"]: exampleText,
//       });
//       settings.save();
//     });

//     // @TODO This is recommended in guide to this pattern ... but api not registered to window.wp

//     window.wp.api.loadPromise.then(() => {
//       this.settings = new window.wp.api.models.Settings();

//       const { isAPILoaded } = this.state;

//       // console.log("isAPILoaded", isAPILoaded);

//       if (isAPILoaded === false) {
//         this.settings.fetch().then((response) => {
//           // console.log("api response", response.cagov_event_detail_example_text);
//           this.setState({
//             exampleText: response.cagov_event_detail_example_text,
//             isAPILoaded: true,
//           }, () => console.log("set the state", this.state));
//         });
//       }
//     });
//   }

//   render() {
//     const { exampleText, isAPILoaded } = this.state;

//     const { setAttributes } = this.props;

//     // console.log("setAttributes", setAttributes);

//     if (!isAPILoaded) {
//       return (
//         <Placeholder>
//           <Spinner />
//         </Placeholder>
//       );
//     }

//     console.log(this.state);
//     return (
//       <Panel>
//         <PanelBody
//           title={__("Example Meta Box", "cagov_event_detail")}
//           icon="admin-plugins"
//         >
//           <TextControl
//             help={__("This is an example text field.", "cagov-event-detail")}
//             label={__("Example Text", "cagov_event_detail")}
//             onChange={(exampleText) => {
//               this.setState({ exampleText });
//               setAttributes({ exampleText });
//             }}
//             value={exampleText}
//           />
//         </PanelBody>
//       </Panel>
//     );
//   }
// }

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
    },
  },
  example: {
    attributes: {
      title: "Event Details",
    },
  },
  edit: function (props) {
    const [openDatePopup, setOpenDatePopup] = useState(false); // @TODO unimplemented can re-implement.

    const {
      title,
      startDate,
      endDate,
      startTime,
      endTime,
      location,
      cost,
    } = props.attributes;

    let formattedStartDate = startDate;
    let formattedEndDate = endDate;
    let formattedStartTime = startTime;
    let formattedEndTime = endTime;

    // https://developer.wordpress.org/block-editor/reference-guides/components/date-time/
    // <OptionsExample {...props} />
    return (
      <div {...useBlockProps()}>
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
            
            <div class="startDate">{formattedStartDate}</div>
            <div class="endDate">{formattedEndDate}</div> <br />
            <div class="startTime">{formattedStartTime}</div>
            <div class="endTime">{formattedEndTime}</div>

            <InspectorControls key="setting">
              <div id="datetime-controls">
                <fieldset>
                  <legend className="blocks-base-control__label">
                    {__("Start Date & Time", "ca-design-system")}
                  </legend>
                  <StartDateTimePicker />
                </fieldset>
                <fieldset>
                  <legend className="blocks-base-control__label">
                    {__("End Date & Time", "ca-design-system")}
                  </legend>
                  <em>End date and time are optional.</em>
                  <EndDateTimePicker />
                </fieldset>
              </div>
            </InspectorControls>

            {/* <RichText
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
            /> */}
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
            {el(InnerBlocks, {
              orientation: "horizontal",
              allowedBlocks: ["core/paragraph", "core/button"],
            })}
          </div>
        </div>
      </div>
    );
  },
  save: function (props) {
    return el(
      "div",
      {
        className:
          "wp-block-ca-design-system-event-detail cagov-event-detail cagov-stack",
      },
      el(InnerBlocks.Content)
    );
  },

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
