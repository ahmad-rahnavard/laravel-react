import React, { Component } from 'react'
import Datatable from '../helpers/datatable'

export default class Home extends Component {

    render() {
        return (
            <div>
                <div className="jumbotron">
                    <div className="container">
                        <h1 className="display-3 text-center pt-5">Welcome!</h1>
                    </div>
                </div>

                <div className="container">
                    <div className="table-responsive">
                        <Datatable />
                    </div>

                    <hr />

                </div>
            </div>
        )
    }
}
